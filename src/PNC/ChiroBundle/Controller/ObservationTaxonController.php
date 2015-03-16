<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ObservationTaxonController extends Controller
{
    public function listAction(){
        return new Response('liste observations taxon');
    }

    public function detailAction($id){
        return new Response('detail observation taxon');
    }

    public function editAction($id=null){
        return new Response('formulaire observation taxon');
    }

    public function saveAction($id=null){
        return new Response('enregistrer observation taxon');
    }

    public function deleteAction($id){
        return new Response('supprimer observation taxon');
    }
}


