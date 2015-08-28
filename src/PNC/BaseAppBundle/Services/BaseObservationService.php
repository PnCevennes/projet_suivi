<?php

namespace PNC\BaseAppBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\BaseAppBundle\Entity\Visite;
use PNC\BaseAppBundle\Entity\Observateurs;

class BaseObservationService{
    private $geometryService;
    private $entityService;

    public function __construct($gs, $es){
        $this->geometryService = $gs;
        $this->entityService = $es;
        $this->schema = array(
            'bvDate'=>'date',
            'geom'=>'point',
            'fkBsId'=>null,
            'bvCommentaire'=>null,
            'metaNumerisateurId'=>null
        );
    }
    
    public function create($db, $data){
        $repo = $db->getRepository('PNCBaseAppBundle:Observateurs');
        $manager = $db->getManager();
        $obs = new Visite();
        $errors = array();

        try{
            $this->entityService->hydrate($obs, $this->schema, $data);
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
        $rObs = $db->getRepository('PNCBaseAppBundle:Visite');
        $manager = $db->getManager();
        $obs = $rObs->findOneBy(array('id'=>$data['id']));
        $errors = array();
        try{
            $this->entityService->hydrate($obs, $this->schema, $data);
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
        $rObs = $db->getRepository('PNCBaseAppBundle:Visite');
        $manager = $db->getManager();
        $obs = $rObs->findOneBy(array('id'=>$id));
        $manager->remove($obs);
        $manager->flush();
        return true;
    }
}
