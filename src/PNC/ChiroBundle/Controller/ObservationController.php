<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller{

    // path: GET /chiro/observation
    public function listAction(){
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationView');
        $infos = $repo->findAll();
        $out = array();

        foreach($infos as $info){
            $out_item = $norm->normalize($info, array('obsDate', 'observateurs'));
            $out_item['obsDate'] = !empty($info->getObsDate()) ? $info->getObsDate()->format('Y-m-d'): '';
            $out_item['observateurs'] = array();
            foreach($info->getObservateurs() as $obr){
                $out_item['observateurs'][] = $norm->normalize($obr);
            }
            $out[] = $out_item;
        }

        return new JsonResponse($out);
    }

    // path: GET /chiro/observation/{id}
    public function detailAction($id){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationView');
        $info = $repo->findOneById($id);
        if(!$info){
            return new JsonResponse(array('v'=>'detail obs', 'err'=>404), 404);
        }
        $out_item = $norm->normalize($info, array('obsDate', ));
        $out_item['observateurs'] = array();
        foreach($info->getObservateurs() as $observateur){
            $out_item['observateurs'][] = $norm->normalize($observateur);
        }

        

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
