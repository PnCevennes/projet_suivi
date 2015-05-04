<?php

namespace PNC\BaseAppBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\BaseAppBundle\Entity\Observation;
use PNC\BaseAppBundle\Entity\Observateurs;

class BaseObservationService{
    
    public function create($db, $data){
        $repo = $db->getRepository('PNCBaseAppBundle:Observateurs');
        $manager = $db->getManager();
        $obs = new Observation();
        $errors = array();

        try{
            $this->hydrate($obs, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
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
            throw new DataObjectException($errors);
        }
        $manager->persist($obs);
        $manager->flush();
        return $obs->getId();
    }

    public function update($db, $id, $data){
        $rObr = $db->getRepository('PNCBaseAppBundle:Observateurs');
        $rObs = $db->getRepository('PNCBaseAppBundle:Observation');
        $manager = $db->getManager();
        $obs = $rObs->findOneBy(array('id'=>$data['id']));
        $errors = array();
        try{
            $this->hydrate($obs, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
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
            throw new DataObjectException($errors);
        }
        $manager->flush();
        return $obs->getId();
    }

    public function remove($db, $id){
        $rObs = $db->getRepository('PNCBaseAppBundle:Observation');
        $manager = $db->getManager();
        $obs = $rObs->findOneBy(array('id'=>$id));
        $manager->remove($obs);
        $manager->flush();
        return true;
    }

    private function hydrate($obj, $data){
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

}
