<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\ChiroBundle\Entity\ObservationTaxon;

class TaxonService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    // service biometrie
    private $biometrieService;

    public function __construct($db, $norm, $biomServ, $pagination){
        $this->db = $db;
        $this->norm = $norm;
        $this->biometrieService = $biomServ;
        $this->pagination = $pagination;
    }

    public function getList($obs_id){
        $out = array();
        if($obs_id){
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
            $data = $repo->findBy(array('obs_id'=>$obs_id));
            foreach($data as $item){
                $out[] = $this->norm->normalize($item, array('dateValidation', 'created', 'updated'));
            }
        }
        return $out;
    }

    public function getFilteredList($request){
        $out = array();
        //$repo = $this->db->getRepository('PNCChiroBundle:ValidationTaxonView');
        /*
        $qb = $this->db->getEntityManager()->createQueryBuilder();
        $qr = $qb->select('v')->from('PNCChiroBundle:ValidationTaxonView', 'v')->setMaxResults(200);*/

        $entity = 'PNCChiroBundle:ValidationTaxonView';
        $page = 0;
        $limit = 200;
        $tx = $request->query->get('taxon');
        $fields = array();
        if($tx){
            $fields[] = array(
                'compare'=>'=',
                'name'=>'cd_nom',
                'value'=>$tx
            );

        }
        $date_start = $request->query->get('period_start');
        if($date_start){
            $ds = new \DateTime();
            $ds->setTimestamp($date_start / 1000);
            $fields[] = array(
                'compare'=>'>',
                'name'=>'obs_date',
                'value'=>$ds//->format('Y-m-d')
            );
        }

        $date_end = $request->query->get('period_end');
        if($date_end){
            $ds = new \DateTime();
            $ds->setTimestamp($date_end / 1000);
            $fields[] = array(
                'compare'=>'<',
                'name'=>'obs_date',
                'value'=>$ds//->format('Y-m-d')
            );
        }

        $st_valid = $request->query->get('st_valid');
        if($st_valid){
            $fields[] = array(
                'compare'=>'=',
                'name'=>'obs_obj_status_validation',
                'value'=>$st_valid,
            );

        }

        //$data = $qr->getQuery()->getResult();
        $res = $this->pagination->filter($entity, $fields, $page, $limit);
        $data = $res['filtered'];
        foreach($data as $item){
            $out_item = array(
                'type'=>'Feature', 
                'properties'=>$this->norm->normalize($item, array('obsDate', 'geom', 'dateValidation', 'observateurs', 'created', 'updated')),
                'geometry'=>$item->getGeom()
                );
        
            $out_item['properties']['obsDate'] = $item->getObsDate()->format('Y-m-d');
            $out_item['properties']['dateValidation'] = $item->getDateValidation() ? $item->getDateValidation()->format('Y-m-d') : '';
            $out_item['properties']['observateurs'] = $item->getObservateurs();
            $out[] = $out_item;
        }
        return array('total'=>$res['total'], 'filtered'=>$out);
    }

    public function getOne($id){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            $out = $this->norm->normalize($data, array('dateValidation', 'created', 'updated'));
            $out['dateValidation'] = $data->getDateValidation() ? $data->getDateValidation()->format('Y-m-d') : '';
            $out['created'] = $data->getCreated() ? $data->getCreated()->format('Y-m-d'): '';
            $out['updated'] = $data->getUpdated() ? $data->getUpdated()->format('Y-m-d'): '';
            return $out;
        }
        return null;
    }
    
    public function create($data, $db=null, $commit=true){
        if($db){
            $manager = $db;
        }
        else{
            $manager = $this->db->getManager();
        }
        if($commit){
            $manager->getConnection()->beginTransaction();
        }
        try{
            $obsTx = new ObservationTaxon();
            $this->hydrate($obsTx, $data);
            $manager->persist($obsTx);
            $manager->flush();
            if(isset($data['__biometries__'])){
                foreach($data['__biometries__'] as $biom){
                    $biom['obsTxId'] = $obsTx->getId();
                    $biom['biomCommentaire'] = '';
                    $this->biometrieService->create($biom, false);
                }
            }
        }
        catch(DataObjectException $e){
            if($commit){
                $manager->getConnection()->rollback();
                throw new DataObjectException($e->getErrors());
            }
        }
        if($commit){
            $manager->getConnection()->commit();
        }
        return array('id'=>$obsTx->getId());
    }

    public function update($id, $data){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return null;
        }
        $this->hydrate($obsTx, $data);
        $manager->flush();
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

    private function hydrate($obj, $data){
        $repo = $this->db->getRepository('PNCBaseAppBundle:Taxons');
        $tx = $repo->findOneBy(array('cd_nom'=>$data['cdNom']));
        $obj->setObsId($data['obsId']);
        $obj->setActId($data['actId'] == '__NULL__' ? null : $data['actId']);
        $obj->setPrvId($data['prvId'] == '__NULL__' ? null : $data['prvId']);
        $obj->setObsTxInitial($data['obsTxInitial']);
        $obj->setObsEspeceIncertaine($data['obsEspeceIncertaine']);
        $obj->setObsEffectifAbs($data['obsEffectifAbs']);
        $obj->setObsNbMaleAdulte($data['obsNbMaleAdulte']);
        $obj->setObsNbFemelleAdulte($data['obsNbFemelleAdulte']);
        $obj->setObsNbMaleJuvenile($data['obsNbMaleJuvenile']);
        $obj->setObsNbFemelleJuvenile($data['obsNbFemelleJuvenile']);
        $obj->setObsNbMaleIndetermine($data['obsNbMaleIndetermine']);
        $obj->setObsNbFemelleIndetermine($data['obsNbFemelleIndetermine']);
        $obj->setObsNbIndetermineAdulte($data['obsNbIndetermineAdulte']);
        $obj->setObsNbIndetermineJuvenile($data['obsNbIndetermineJuvenile']);
        $obj->setObsNbIndetermineIndetermine($data['obsNbIndetermineIndetermine']);
        $obj->setObsObjStatusValidation($data['obsObjStatusValidation']);
        $obj->setObsCommentaire($data['obsCommentaire']);
        $obj->setCdNom($data['cdNom']);
        $obj->setNomComplet($tx->getNomComplet());
        $obj->setObsValidateur($data['obsValidateur']);
        if($obj->errors()){
            throw new \Exception($obj->errors()); 
        }
    }

}


