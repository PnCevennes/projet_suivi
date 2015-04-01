<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
            $out_item['obsDate'] = !empty($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
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
            $out_item['obsDate'] = !empty($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
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
        $out_item['obsDate'] = !empty($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
        $out_item['observateurs'] = array();
        foreach($info->getObservateurs() as $observateur){
            if($observateur->getRole() == 'observateur'){
                $out_item['observateurs'][] = $norm->normalize($observateur);
            }
        }

        //TODO ajouter liste des obs taxons + biometries

        return new JsonResponse($out_item);

    }

    // path: PUT /chiro/observation
    public function createAction(Request $req){

    }

    // path: POST /chiro/observation/{id}
    public function updateAction(Request $req, $id){

    }

    // path: DELETE /chiro/observation/{id}
    public function deleteAction($id){

    }
}
