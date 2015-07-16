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
        if(!$siteId){
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationSsSiteView');
            $infos = $repo->findAll();
        }
        else{
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationView');
            $infos = $repo->findBy(array('site_id'=>$siteId));
        }
        $out = array();
        foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('obsDate', 'geom', 'observateurs', 'created', 'updated', 'refCommune'));
            $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
            $out_item['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                if($obr->getRole() == 'observateur'){
                    $out_item['observateurs'][] = $obr->getNomComplet();
                }
            }
            if(!$siteId){
                $out_item['geom'] = $info->getGeom();
            }

            $out_item['geomLabel'] = sprintf('<a href="#/chiro/inventaire/%s">Observation du %s</a>',
                $info->getId(), $info->getObsDate()->format('d/m/Y'));

            $out[] = $out_item;
        }

        return $out;
    }

    public function getOne($id){
        $has_geom = false;
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationView');
        $info = $repo->findOneById($id);
        if(!$info){
            $has_geom = true;
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationSsSiteView');
            $info = $repo->findOneById($id);
            if(!$info){
                return null;
            }
        }
        $out_item = $this->norm->normalize($info, array('obsDate', 'geom', 'observateurs', 'created', 'updated', 'refCommune'));
        $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
        $out_item['created'] = !is_null($info->getCreated()) ? $info->getCreated()->format('Y-m-d'): '';
        $out_item['updated'] = !is_null($info->getUpdated()) ? $info->getUpdated()->format('Y-m-d'): '';
        $out_item['refCommune'] = $info->getRefCommune() ? $info->getRefCommune() : ' ';
        $out_item['observateurs'] = array();
        foreach($info->getObservateurs() as $observateur){
            if($observateur->getRole() == 'observateur'){
                $out_item['observateurs'][] = $observateur->getObrId();
            }
        }
        if($has_geom){
            $out_item['geom'] = array($info->getGeom()['coordinates']);
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
        if(isset($data['__taxons__'])){
            try{
                foreach($data['__taxons__'] as $taxon){
                    $taxon['obsId'] = $resObs;
                    $taxon['numId'] = $data['numerisateurId'];
                    $taxon['obsObjStatusValidation'] = 56;
                    $taxon['obsCommentaire'] = '';
                    $taxon['obsValidateur'] = null;

                    $this->taxonService->create($taxon, false);
                }

            }
            catch(DataObjectException $e){
                $manager->getConnection()->rollback();
                $errors = $e->getErrors();
                throw new DataObjectException($errors);
            }
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
                $this->taxonService->remove($taxon['id'], $cascade);
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
        $obj->setModId($data['modId']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors());
        }
    }
}

