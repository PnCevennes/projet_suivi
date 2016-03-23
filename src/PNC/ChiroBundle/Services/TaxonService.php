<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\ChiroBundle\Entity\ObservationTaxon;
use PNC\ChiroBundle\Entity\ObstaxonFichiers;
use PNC\ChiroBundle\Entity\ObstaxonIndices;


class TaxonService{
    // doctrine
    private $db;

    // service biometrie
    private $biometrieService;

    public function __construct($db, $biomServ, $pagination, $es, $fs){
        $this->db = $db;
        $this->biometrieService = $biomServ;
        $this->pagination = $pagination;
        $this->entityService = $es;
        $this->fileService = $fs;
    }

    public function getList($fk_bv_id){
        $out = array();
        if($fk_bv_id){
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
            $data = $repo->findBy(array('fk_bv_id'=>$fk_bv_id));
            foreach($data as $item){
                $out[] = $this->entityService->normalize($item, $schema);
            }
        }
        return $out;
    }

    public function getFilteredList($request, $obsId=null){
        $out = array();

        if(!$obsId){
            $entity = 'PNCChiroBundle:ValidationTaxonView';
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ValidationTaxonView.orm.yml';
            $cpl = array();
        }
        else{
            $entity = 'PNCChiroBundle:ObservationTaxon';
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
            $cpl = array(
                array(
                    'name'=>'fk_bv_id',
                    'compare'=>'=',
                    'value'=>$obsId
                )
            );
        }
        $filters = json_decode($request->query->get('filters'), true);
        $page = $request->query->get('page', 0);
        $limit = $request->query->get('limit', 30);

        $res = $this->pagination->filter_request($entity, $request, $cpl);
        $data = $res['filtered'];
        
        if($obsId){
            foreach($data as $item){
                $out[] = $this->entityService->normalize($item, $schema);
            }
        }
        else{
            foreach($data as $item){
                $out_item = array(
                    'type'=>'Feature', 
                    'properties'=>$this->entityService->normalize($item, $schema),
                    'geometry'=>$item->getGeom()
                    );
                $out[] = $out_item;
            }
        }
        return array('total'=>$res['total'], 'filteredCount'=>$res['filteredCount'], 'filtered'=>$out);
    }

    public function getOne($id){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
        //$fichiers_schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObstaxonFichiers.orm.yml';
        $fichiers_schema = '../src/PNC/BaseAppBundle/Resources/config/doctrine/Fichiers.orm.yml';
        $data = $this->entityService->getOne(
            'PNCChiroBundle:ObservationTaxon', 
            array('id'=>$id)
        );
        if($data){
            $fichiers = $this->entityService->getAll(
                'PNCChiroBundle:ObstaxonFichiers',
                array('cotx_id'=>$id)
            );
            $out = $this->entityService->normalize($data, $schema);
            $out['obsTaxonFichiers'] = $this->fileService->getFichiers('chiro/obsTaxon', $id); 
            $out['indices'] = array();
            $indices = $this->entityService->getAll(
                'PNCChiroBundle:ObstaxonIndices',
                array('cotx_id'=>$id)
            );
            foreach($indices as $indice){
                $out['indices'][] = $indice->getThesaurusId();
            }

            return $out;
        }


        return null;
    }
    
    public function create($data, $db=null, $commit=true){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
        if($db){
            $manager = $db;
        }
        else{
            $manager = $this->entityService->getManager();
            $manager->getConnection()->beginTransaction();
        }

        $tx = $this->entityService->getOne(
            'PNCBaseAppBundle:Taxons', 
            array('cd_nom'=>$data['cotxCdNom'])
        );
        $data['cotxNomComplet'] = $tx->getNomComplet();

        $result = $this->entityService->create(
            array(
                $schema=>array(
                    'entity'=>new ObservationTaxon(),
                    'data'=>$data
                )
            ),
            $manager
        );
        $obsTx = $result[$schema];

        if(isset($data['__biometries__'])){
            foreach($data['__biometries__'] as $biom){
                $biom['fkCotxId'] = $obsTx->getId();
                $biom['cbioCommentaire'] = '';
                $this->biometrieService->create($biom, $manager);
            }
        }

        $this->fileService->record_files($obsTx->getId(), $data['siteFichiers'], $manager);

        if(!$db){
            $manager->getConnection()->commit();
        }

        if(isset($data['indices'])){
            $this->_record_indices($obsTx->getId(), $data['indices']);
        }

        return array('id'=>$obsTx->getId());
    }

    public function update($id, $data){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
        $tx = $this->entityService->getOne(
            'PNCBaseAppBundle:Taxons', 
            array('cd_nom'=>$data['cotxCdNom'])
        );
        $data['cotxNomComplet'] = $tx->getNomComplet();

        $result = $this->entityService->update(
            array(
                $schema=>array(
                    'repo'=>'PNCChiroBundle:ObservationTaxon',
                    'filter'=>array('id'=>$id),
                    'data'=>$data
                )
            )
        );

        $this->_record_indices($id, $data['indices']);

        $obsTx = $result[$schema];
        $this->fileService->record_files($obsTx->getId(), $data['obsTaxonFichiers']);
        return array('id'=>$obsTx->getId());
    }

    public function remove($id, $cascade=false){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return false;
        }
        $biometries = $this->biometrieService->getList($id);
        if($cascade){
            foreach($biometries as $biom){
                $this->biometrieService->remove($biom['id']);
            }
        }
        else{
            if($biometries){
                throw new CascadeException();
            }
        }

        $manager->remove($obsTx);
        $manager->flush();
        $this->fileService->delete_all('chiro/obsTaxon', $id);

        $this->_delete_indices($obsTx->getId());
        return true;
    }

    public function setValidationStatus($data, $user){
        $valid = $data['action'];
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        foreach($data['selection'] as $id){
            $tx = $repo->findOneBy(array('id'=>$id));
            if($tx->getCotxObjStatusValidation() != $valid){
                $tx->setCotxObjStatusValidation($valid);
                $tx->setCotxDateValidation(new \DateTime());
                $tx->setCotxValidateur($user['id_role']);
                $manager->flush();
            }
        }
        $manager->getConnection()->commit();
    }

    private function _record_indices($obsTxId, $data){
        $this->_delete_indices($obsTxId);
        if(!$data){ 
            return null;
        }

        $manager = $this->db->getManager();

        foreach($data as $indice_id){
            $indice = new ObstaxonIndices();
            $indice->setCotxId($obsTxId);
            $indice->setThesaurusId($indice_id);
            $manager->persist($indice);
            $manager->flush();
        }

    }

    private function _delete_indices($obsTxId){

        $manager = $this->db->getManager();
        
        // suppression des liens existants
        $delete = $manager->getConnection()->prepare('DELETE FROM chiro.rel_observationtaxon_thesaurus_indice WHERE cotx_id=:cotxid');
        $delete->bindValue('cotxid', $obsTxId);
        $delete->execute();
    }
}


