<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\ChiroBundle\Entity\ObservationTaxon;

class TaxonService{
    // doctrine
    private $db;

    // service biometrie
    private $biometrieService;

    public function __construct($db, $biomServ, $pagination, $es){
        $this->db = $db;
        $this->biometrieService = $biomServ;
        $this->pagination = $pagination;
        $this->entityService = $es;
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
        $data = $this->entityService->getOne(
            'PNCChiroBundle:ObservationTaxon', 
            array('id'=>$id)
        );
        if($data){
            $out = $this->entityService->normalize($data, $schema);
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
            array('cd_nom'=>$data['cdNom'])
        );
        $data['nomComplet'] = $tx->getNomComplet();

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
        if(!$db){
            $manager->getConnection()->commit();
        }

        return array('id'=>$obsTx->getId());
    }

    public function update($id, $data){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
        $tx = $this->entityService->getOne(
            'PNCBaseAppBundle:Taxons', 
            array('cd_nom'=>$data['cdNom'])
        );
        $data['nomComplet'] = $tx->getNomComplet();

        $result = $this->entityService->update(
            array(
                $schema=>array(
                    'repo'=>'PNCChiroBundle:ObservationTaxon',
                    'filter'=>array('id'=>$id),
                    'data'=>$data
                )
            )
        );

        $obsTx = $result[$schema];
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
        return true;
    }

    public function setValidationStatus($data, $user){
        $valid = $data['action'];
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        foreach($data['selection'] as $id){
            $tx = $repo->findOneBy(array('id'=>$id));
            if($tx->getObsObjStatusValidation() != $valid){
                $tx->setObsObjStatusValidation($valid);
                $tx->setDateValidation(new \DateTime());
                $tx->setObsValidateur($user['id_role']);
                $manager->flush();
            }
        }
        $manager->getConnection()->commit();
    }
}


