<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ConfigController extends Controller{
    //path : chiro/breadcrumb
    public function breadcrumbAction(Request $req){
        $view = $req->get('view');
        $id = $req->get('id');

        $manager = $this->getDoctrine()->getConnection();

        $out = array();
        switch($view){
            case 'biometrie':
                $req = $manager->prepare('SELECT id, obs_tx_id FROM chiro.chiro_biometrie WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>'Biometrie n°'.$id);
                $id = $res['obs_tx_id'];
            case 'taxon':
                $req = $manager->prepare('SELECT id, nom_complet as label, obs_id FROM chiro.chiro_observation_taxon WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>$res['label']);
                $id = $res['obs_id'];
            case 'observation':
                $req = $manager->prepare('SELECT id, obs_date as label, site_id FROM pnc.base_observation WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>$res['label']);
                if($res['site_id']==null){
                    return new JsonResponse($out);
                }
                $id = $res['site_id'];
            case 'site':
                $req = $manager->prepare('SELECT id, site_nom as label FROM pnc.base_site WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>$res['label']);
        }
        return new JsonResponse($out);
    }
}
