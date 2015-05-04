<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\BaseAppBundle\Entity\Observation;
use PNC\BaseAppBundle\Entity\Observateurs;
use PNC\ChiroBundle\Entity\ConditionsObservation;


class ObservationService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
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
        $repo = $this->db->getRepository('PNCBaseAppBundle:Observateurs');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $obs = new Observation();
        $cobs = new ConditionsObservation();
        $errors = array();
        try{
            $this->hydrateBase($obs, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
        }
        try{
            $this->hydrateExt($cobs, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors()); 
        }
        foreach($data['observateurs'] as $obr_id){
            $obr = $repo->findOneBy(array('id_role'=>$obr_id));
            if($obr){
                $obs->addObservateur($obr);
            }
            else{
                if(!isset($errors['observateurs'])){
                    $errors['observateurs'] = array();
                }
                $errors['observateurs'][] = 'Utilisateur inconnu';
            }
        }
        if($errors){
            $manager->getConnection()->rollback();
            throw new DataObjectException($errors);
        }
        
        $manager->persist($obs);
        $manager->flush();

        $cobs->setObsId($obs->getId());
        $manager->persist($cobs);
        $manager->flush();
        $manager->getConnection()->commit();
        return array('id'=>$obs->getId());
    }

    public function update($id, $data){
        $rObr = $this->db->getRepository('PNCBaseAppBundle:Observateurs');
        $rObs = $this->db->getRepository('PNCBaseAppBundle:Observation');
        $rCobs = $this->db->getRepository('PNCChiroBundle:ConditionsObservation');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();

        $obs = $rObs->findOneBy(array('id'=>$data['id']));
        $cobs = $rCobs->findOneBy(array('obs_id'=>$data['id']));
        $errors = array();
        try{
            $this->hydrateBase($obs, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
        }
        try{
            $this->hydrateExt($cobs, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors()); 
        }
        foreach($obs->getObservateurs() as $dObr){
            $obs->removeObservateur($dObr);
        }
        foreach($data['observateurs'] as $obr_id){
            $obr = $rObr->findOneBy(array('id_role'=>$obr_id));
            if($obr){
                $obs->addObservateur($obr);
            }
            else{
                if(!isset($errors['observateurs'])){
                    $errors['observateurs'] = array();
                }
                $errors['observateurs'][] = 'Utilisateur inconnu';
            }
        }
        if($errors){
            $manager->getConnection()->rollback();
            throw new DataObjectException($errors);
        }
        $manager->flush();
        $manager->getConnection()->commit();
        return array('id'=>$data['id']);
    }

    public function remove($id){
        $rObs = $this->db->getRepository('PNCBaseAppBundle:Observation');
        $rCobs = $this->db->getRepository('PNCChiroBundle:ConditionsObservation');
        $manager = $this->db->getManager();
        $obs = $rObs->findOneBy(array('id'=>$id));
        $cobs = $rCobs->findOneBy(array('obs_id'=>$id));
        
        $manager->getConnection()->beginTransaction();
        try{
            $manager->remove($cobs);
            $manager->flush();
            $manager->remove($obs);
            $manager->flush();
            $manager->getConnection()->commit();
            return true;
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            return false;
        }

    }

    private function hydrateBase($obj, $data){
        if(strpos($data['obsDate'], '/')!==false){
            $date = \DateTime::createFromFormat('d/m/Y', $data['obsDate']);
        }
        else{
            $date = \DateTime::createFromFormat('Y-m-d', substr($data['obsDate'], 0, 10));
        }
        $obj->setObsDate($date);
        $obj->setObsCommentaire($data['obsCommentaire']);
        $obj->setNumerisateurId($data['numerisateurId']);
        $obj->setSiteId($data['siteId']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }

    private function hydrateExt($obj, $data){
        $obj->setObsTemperature($data['obsTemperature']);
        $obj->setObsHumidite($data['obsHumidite']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors());
        }
    }
}

