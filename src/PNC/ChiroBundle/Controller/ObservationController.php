<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\BaseAppBundle\Entity\Observation;
use PNC\BaseAppBundle\Entity\Observateurs;
use PNC\ChiroBundle\Entity\ConditionsObservation;

class ObservationController extends Controller{

    // path: GET /chiro/observation
    public function listAction(){
        /*
         * retourne la liste complete des observations
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationView');
        $infos = $repo->findAll();
        $out = array();

        foreach($infos as $info){
            $out_item = $norm->normalize($info, array('obsDate', 'observateurs'));
            $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
            $out_item['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                if($obr->getRole() == 'observateur'){
                    $out_item['observateurs'][] = $norm->normalize($obr);
                }
            }
            $out[] = $out_item;
        }

        return new JsonResponse($out);
    }

    // path: GET /chiro/observation/site/{id}
    public function listSiteAction($id){
        /*
         * retourne la liste des observations associées à un site
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationView');
        $infos = $repo->findBy(array('site_id'=>$id));
        $out = array();

        foreach($infos as $info){
            $out_item = $norm->normalize($info, array('obsDate', 'observateurs'));
            $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
            $out_item['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                if($obr->getRole() == 'observateur'){
                    $out_item['observateurs'][] = $norm->normalize($obr);
                }
            }
            $out[] = $out_item;
        }

        return new JsonResponse($out);
    }

    // path: GET /chiro/observation/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'une observation
         */
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationView');
        $info = $repo->findOneById($id);
        if(!$info){
            return new JsonResponse(array('v'=>'detail obs', 'err'=>404), 404);
        }
        $out_item = $norm->normalize($info, array('obsDate', 'observateurs'));
        $out_item['obsDate'] = !is_null($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
        $out_item['observateurs'] = array();
        foreach($info->getObservateurs() as $observateur){
            if($observateur->getRole() == 'observateur'){
                //$out_item['observateurs'][] = $norm->normalize($observateur);
                $out_item['observateurs'][] = $observateur->getObrId();
            }
        }

        //TODO ajouter liste des obs taxons + biometries

        return new JsonResponse($out_item);

    }

    private function hydrateObservation($obs, $data){
        $obs->setObsDate(\DateTime::createFromFormat('d/m/Y', $data['obsDate']));
        $obs->setObsCommentaire($data['obsCommentaire']);
        //$obs->setObsIdTableSrc($data['obsIdTableSrc']);
        $obs->setSiteId($data['siteId']);
        if($obs->errors()){
            throw new \Exception(); //TODO lever une exception explicite
        }
    }

    private function hydrateConditionsObservation($cobs, $data){
        $cobs->setObsTemperature($data['obsTemperature']);
        $cobs->setObsHumidite($data['obsHumidite']);
        if($cobs->errors()){
            throw new \Exception(); //TODO lever une exception explicite
        }
    }



    // path: PUT /chiro/observation
    public function createAction(Request $req){
        $data = json_decode($req->getContent(), true);
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observateurs');

        
        // manager de base de données
        $manager = $this->getDoctrine()->getManager();
        // initialisation transaction
        $manager->getConnection()->beginTransaction();
        
        $obs = new Observation();
        $cobs = new ConditionsObservation();
        try{
            $this->hydrateObservation($obs, $data);
            $this->hydrateConditionsObservation($cobs, $data);
            foreach($data['observateurs'] as $obr_id){
                $obr = $repo->findOneBy(array('id_role'=>$obr_id));
                if($obr){
                    $obs->addObservateur($obr);
                }
            }
            $manager->persist($obs);
            $manager->flush();

            $cobs->setObsId($obs->getId());
            $manager->persist($cobs);
            $manager->flush();
            $manager->getConnection()->commit();
            return new JsonResponse(array('id'=>$obs->getId()));
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            $errs = array_merge($obs->errors(), $cobs->errors());
            return new JsonResponse($errs, 400);
        }
    }

    // path: POST /chiro/observation/{id}
    public function updateAction(Request $req, $id){
        $data = json_decode($req->getContent(), true);
        $rObr = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observateurs');
        $rObs = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observation');
        $rCobs = $this->getDoctrine()->getRepository('PNCChiroBundle:ConditionsObservation');

        // manager de base de données
        $manager = $this->getDoctrine()->getManager();
        // initialisation transaction
        $manager->getConnection()->beginTransaction();

        try{
            $obs = $rObs->findOneBy(array('id'=>$data['id']));
            $cobs = $rCobs->findOneBy(array('obs_id'=>$data['id']));
            $this->hydrateObservation($obs, $data);
            $this->hydrateConditionsObservation($cobs, $data);

            foreach($obs->getObservateurs() as $_obr){
                $obs->removeObservateur($_obr);
            }
            foreach($data['observateurs'] as $obr_id){
                $obr = $rObr->findOneBy(array('id_role'=>$obr_id));
                if($obr){
                    $obs->addObservateur($obr);
                }
            }
            $manager->flush();

            $manager->getConnection()->commit();
            return new JsonResponse(array('id', $data['id']));
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            $errs = array_merge($obs->errors(), $cobs->errors());

            return new JsonResponse($errs, 400);
        }
    }

    // path: DELETE /chiro/observation/{id}
    public function deleteAction($id){
        $rObs = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observation');
        $rCobs = $this->getDoctrine()->getRepository('PNCChiroBundle:ConditionsObservation');
        
        // manager de base de données
        $manager = $this->getDoctrine()->getManager();
        // initialisation transaction
        $manager->getConnection()->beginTransaction();

        try{
            $obs = $rObs->findOneBy(array('id'=>$id));
            $cobs = $rCobs->findOneBy(array('obs_id'=>$id));

            //TODO Ajouter sécurités
            $manager->remove($cobs);
            $manager->flush();
            $manager->remove($obs);
            $manager->flush();
            $manager->getConnection()->commit();

            return new JsonResponse(array('id'=>$id));
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            return new JsonResponse(array('err'=>$e->getMessage()), 422);
        }
        
    }
}
