<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BiometrieController extends Controller
{
    // path: GET chiro/biometrie/taxon/{otx_id}
    public function listAction($otx_id=null){
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findBy(array('obs_tx_id'=>$otx_id));

        $out = array();
        foreach($data as $item){
            $out[] = $norm->normalize($item);
        }
        return new JsonResponse($out);
    }

    // path: GET chiro/biometrie/{id}
    public function detailAction($id){
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            $out = $norm->normalize($data);
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>$id), 404);
    }

    // path: PUT chiro/biometrie
    public function createAction($id=null){
        return new Response('formulaire biometrie');
    }

    // path: POST chiro/biometrie/{id}
    public function updateAction($id=null){
        return new Response('enregistrer biometrie');
    }

    // path: DELETE chiro/biometrie/{id}
    public function deleteAction($id){
        return new Response('supprimer biometrie');
    }
}


