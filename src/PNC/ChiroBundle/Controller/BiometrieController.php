<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BiometrieController extends Controller
{
    public function listAction(){
        return new Response('liste biometries');
    }

    public function detailAction($id){
        return new Response('detail biometrie');
    }

    public function editAction($id=null){
        return new Response('formulaire biometrie');
    }

    public function saveAction($id=null){
        return new Response('enregistrer biometrie');
    }

    public function deleteAction($id){
        return new Response('supprimer biometrie');
    }
}


