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

    public function __construct($db, $taxonServ, $parentServ, $es, $pg){
        $this->db = $db;
        $this->taxonService = $taxonServ;
        $this->parentService = $parentServ;
        $this->entityService = $es;
        $this->pagination = $pg;
    }

    public function getFilteredList($request){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationSsSiteView.orm.yml';
        $entity = 'PNCChiroBundle:ObservationSsSiteView';

        $filters = json_decode($request->query->get('filters'), true);
        $page = $request->query->get('page', 0);
        $limit = $request->query->get('limit', null);
        $fields = array();

        if($filters){
            foreach($filters as $filter){
                $fields[] = array(
                    'name'=>$filter['item'],
                    'compare'=>$filter['filter'],
                    'value'=>$filter['value']
                );
            }
        }

        $res = $this->pagination->filter($entity, $fields, $page, $limit);

        $infos = $res['filtered'];

        $out = array();
        foreach($infos as $info){
            $data = $this->entityService->normalize($info, $schema);
            $out_item = array(
                'type'=>'Feature',
                'geometry'=>$info->getGeom(),
                'properties'=>$data);
            $out_item['properties']['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                if($obr->getRole() == 'observateur'){
                    $out_item['properties']['observateurs'][] = $obr->getNomComplet();
                }
            }

            $out_item['properties']['geomLabel'] = sprintf('<a href="#/chiro/inventaire/%s">Observation du %s</a>',
                $info->getId(), $info->getObsDate()->format('d/m/Y'));

            $out[] = $out_item;
        }

        return array('total'=>$res['total'], 'filteredCount'=>$res['filteredCount'], 'filtered'=>$out);
    }

    public function getList($siteId=null){
        if(!$siteId){
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationSsSiteView');
            $infos = $repo->findAll();
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationSsSiteView.orm.yml';
        }
        else{
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationView');
            $infos = $repo->findBy(array('site_id'=>$siteId));
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationView.orm.yml';
        }
        $out = array();
        foreach($infos as $info){
            $out_item = $this->entityService->normalize($info, $schema);
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
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationView.orm.yml';
        if(!$info){
            $has_geom = true;
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationSsSiteView');
            $info = $repo->findOneById($id);
            $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationSsSiteView.orm.yml';
            if(!$info){
                return null;
            }
        }
        $out_item = $this->entityService->normalize($info, $schema);
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
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ConditionsObservation.orm.yml';
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
            $this->entityService->hydrate($cobs, $schema, $data);
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
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ConditionsObservation.orm.yml';
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
            $this->entityService->hydrate($cobs, $schema, $data);
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
}

