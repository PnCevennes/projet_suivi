<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{
    // path: /site
    public function listAction(Request $req){
        $base = $this->get('BaseSiteService');
        //$db->test();
        $out = $base->normalize($base->getListByApp(1));
        return new JsonResponse(array('v'=>'liste sites', 'r'=>$out));
    }
    // path: /site/detail/{id}
    public function detailAction(Request $req, $id){
        $base = $this->get('BaseSiteService');
        $out = $base->normalize($base->getById($id));
        return new JsonResponse(array('v'=>'detail site', 'r'=>$out));
    }
    // path: /site/editer/{id}
    public function editAction(Request $req, $id=null){
        return new Response('formulaire site');
    }
    // path: /site/enreg
    public function saveAction(Request $req){
        return new Response('enregistrer site');
    }
    // path: /site/suppr/{id}
    public function deleteAction(Request $req, $id){
        return new Response('supprimer site');
    }
}

