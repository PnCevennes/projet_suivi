<?php

namespace PNC\ChiroBundle\Services;

use PNC\ChiroBundle\Entity\ConditionsObservation;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

class ObservationService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    //service taxon
    private $taxonService;

    // baseObservation
    private $parentService;

    public function __construct($db, $norm, $taxonServ, $parentServ){
        $this->db = $db;
        $this->norm = $norm;
        $this->taxonService = $taxonServ;
        $this->parentService = $parentServ;
    }

    public function getList($siteId=null){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationView');
        if(!$siteId){
            $infos = $repo->findAll();
        }
        else{
            $infos = $repo->findBy(array('site_id'=>$siteId));
        }
        $out = array();
        foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('obsDate', 'observateurs'));
            $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
            $out_item['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                if($obr->getRole() == 'observateur'){
                    $out_item['observateurs'][] = $obr->getNomComplet();
                }
            }
            $out[] = $out_item;
        }
        return $out;
    }

    public function getOne($id){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationView');
        $info = $repo->findOneById($id);
        if(!$info){
            return null;
        }
        $out_item = $this->norm->normalize($info, array('obsDate', 'observateurs'));
        $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
        $out_item['observateurs'] = array();
        foreach($info->getObservateurs() as $observateur){
            if($observateur->getRole() == 'observateur'){
                $out_item['observateurs'][] = $observateur->getObrId();
            }
        }
        return $out_item;
    }

    public function create($data){
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $errors = array();

        try{
            $resObs = $this->parentService->create($this->db, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
        }
        try{
            $cobs = new ConditionsObservation();
            $this->hydrate($cobs, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors()); 
        }
        if($errors){
            $manager->getConnection()->rollback();
            throw new DataObjectException($errors);
        }

        $cobs->setObsId($resObs);
        $manager->persist($cobs);
        $manager->flush();
        $manager->getConnection()->commit();
        return array('id'=>$resObs);
    }

    public function update($id, $data){
        $rCobs = $this->db->getRepository('PNCChiroBundle:ConditionsObservation');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();

        $cobs = $rCobs->findOneBy(array('obs_id'=>$data['id']));
        $errors = array();
        try{
            $resObs = $this->parentService->update($this->db, $id, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors(); 
        }
        try{
            $this->hydrate($cobs, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors()); 
        }
        if($errors){
            $manager->getConnection()->rollback();
            throw new DataObjectException($errors);
        }
        $manager->flush();
        $manager->getConnection()->commit();
        return array('id'=>$data['id']);
    }

    public function remove($id, $cascade=false){
        $rCobs = $this->db->getRepository('PNCChiroBundle:ConditionsObservation');
        $manager = $this->db->getManager();
        $cobs = $rCobs->findOneBy(array('obs_id'=>$id));
        $taxons = $this->taxonService->getList($id);
        if($cascade){
            foreach($taxons as $taxon){
                $this->taxonService->remove($taxon->getId(), $cascade);
            }
        }
        else{
            if($taxons){
                throw new CascadeException();
            }
        }
        
        $manager->getConnection()->beginTransaction();
        try{
            $manager->remove($cobs);
            $manager->flush();
            $resObs = $this->parentService->remove($this->db, $id);
            $manager->getConnection()->commit();
            return true;
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            return false;
        }
    }

    private function hydrate($obj, $data){
        $obj->setObsTemperature($data['obsTemperature']);
        $obj->setObsHumidite($data['obsHumidite']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors());
        }
    }
}

