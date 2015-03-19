<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller{
    
    // path: GET /chiro/site
    public function listAction(){
        /*
         * retourne la liste des sites "chiro"
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:SiteView');
        $infos = $repo->findAll();
        $out = array();

        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = $norm->normalize($info, array('siteDate', 'geom', 'dernObs'));
            $out_item['properties']['siteDate'] = !empty($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
            $out_item['properties']['dernObservation'] = !empty($info->getDernObs()) ? $info->getDerObs()->format('Y-m-d'): '';
            $out_item['geometry'] = $info->getGeom();
            $out[] = $out_item;
        }

        return new JsonResponse($out);
    }


    // path: GET /chiro/site/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'un site chiro
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:SiteView');
        $info = $repo->findOneById($id);
        if(!$info){
            return new JsonResponse(array('v'=>'detail site', 'err'=>404));
        }

        $out_item = array('type'=>'Feature');
        $out_item['properties'] = $norm->normalize($info, array('siteDate', 'geom', 'dernObs'));
            $out_item['properties']['siteDate'] = !empty($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
            $out_item['properties']['dernObservation'] = !empty($info->getDernObs()) ? $info->getDerObs()->format('Y-m-d'): '';
        $out_item['geometry'] = $info->getGeom();

        return new JsonResponse($out_item);
    }


    // path: PUT /chiro/site
    public function CreateAction($id=null){
        return new Response('formulaire site chiro');
    }


    // path: POST/chiro/site/{id}
    public function UpdateAction($id=null){
        return new Response('enregistrer site chiro');
    }


    // path; DELETE /chiro/site/{id}
    public function deleteAction($id){
        return new Response('supprimer site chiro');
    }
}
