<?php

namespace PNC\PatrimoineBatiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ConfigController extends Controller{
    //path : chiro/breadcrumb
    public function breadcrumbAction(Request $req){
        $view = $req->get('view');
        $id = $req->get('id');
        $generic = $req->get('generic') == "true";

        $manager = $this->getDoctrine()->getConnection();

        $out = array();
        switch($view){
            case 'site':
                $req = $manager->prepare('SELECT id, bs_nom as label FROM suivi.pr_base_site WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array(array('id'=>null, 'label'=>'Sites', 'link'=>'#/patrimoinebati/site')));
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>$res['label'], 'link'=>$generic ? '#/g/patrimoinebati/site/detail/'.$id : '#/patrimoinebati/site/'.$id);
                $out[] = array('id'=>null, 'label'=>'Sites', 'link'=>$generic ? '#/g/patrimoinebati/site/list' : '#/patrimoinebati/site');
        }
        return new JsonResponse(array_reverse($out));
    }
}
