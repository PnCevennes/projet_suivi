<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ObservationController extends Controller
{
    public function listAction(){
        $base = $this->get('BaseObsService');
        $out = $base->normalize($base->getBySite(1));

        return new JsonResponse(array('r'=>'liste observations site', 'o'=>$out));
    }

    public function detailAction($id){
        $base = $this->get('BaseObsService');
        $out = $base->normalize($base->getByObservateur($id));

        return new JsonResponse(array('r'=>'liste observations observateur', 'o'=>$out));
    }

    public function editAction($id=null){
        return new Response('formulaire observation');
    }

    public function saveAction($id=null){
        return new Response('enregistrer observation');
    }

    public function deleteAction($id){
        return new Response('supprimer observation');
    }
}
