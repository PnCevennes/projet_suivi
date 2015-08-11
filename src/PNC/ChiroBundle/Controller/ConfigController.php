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
        $generic = $req->get('generic');

        $manager = $this->getDoctrine()->getConnection();

        $out = array();
        switch($view){
            case 'biometrie':
                $req = $manager->prepare('SELECT id, fk_cotx_id FROM chiro.subpr_observationtaxon_biometrie WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array(
                    'id'=>$res['id'], 
                    'label'=>'Biometrie n°'.$id, 
                    'link'=> $generic ? '#/g/chiro/biometrie/detail/'.$id : '#/chiro/biometrie/'.$id
                );
                $id = $res['fk_cotx_id'];
            case 'taxons': 
            case 'taxon':
                $req = $manager->prepare('SELECT id, nom_complet as label, fk_bv_id FROM chiro.pr_visite_observationtaxon WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array('id'=>null), 404);
                }
                $res = $res[0];
                $out[] = array(
                    'id'=>$res['id'], 
                    'label'=>$res['label'], 
                    'link'=> $generic ? '#/g/chiro/taxons/detail/'.$id : '#/chiro/taxons/'.$id
                );
                $id = $res['fk_bv_id'];
            case 'validation':
                if($view == 'validation'){
                    return new JsonResponse(array(array('id'=>null, 'label'=>'Validation', 'link'=>'#/chiro/validation')));
                }
            case 'inventaire':
            case 'observation':
                $req = $manager->prepare('SELECT id, bv_date as label, fk_bs_id FROM suivi.pr_base_visite WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array(array('id'=>null, 'label'=>'Inventaire', 'link'=>'#/chiro/inventaire')));
                }
                $res = $res[0];
                if($res['fk_bs_id']==null){
                    $out[] = array(
                        'id'=>$res['id'], 
                        'label'=>implode('/', array_reverse(explode('-', $res['label']))), //transformation date Y-m-d -> d/m/Y
                        'link'=> $generic ? '#/g/chiro/inventaire/detail/'.$id : '#/chiro/inventaire/'.$id);
                    $out[] = array(
                        'id'=>null, 
                        'label'=>'Inventaire', 
                        'link'=> $generic ? '#/g/chiro/inventaire/list' : '#/chiro/inventaire');
                    return new JsonResponse(array_reverse($out));
                }
                $out[] = array(
                    'id'=>$res['id'], 
                    'label'=>implode('/', array_reverse(explode('-', $res['label']))), //transformation date Y-m-d -> d/m/Y
                    'link'=> $generic ? '#/g/chiro/observation/detail/'.$id : '#/chiro/observation/'.$id);
                $id = $res['fk_bs_id'];
            case 'site':
                $req = $manager->prepare('SELECT id, bs_nom as label FROM suivi.pr_base_site WHERE id=:id');
                $req->bindValue('id', $id);
                $req->execute();
                $res = $req->fetchAll();
                if(!isset($res[0])){
                    return new JsonResponse(array(array('id'=>null, 'label'=>'Sites', 'link'=>'#/chiro/site')));
                }
                $res = $res[0];
                $out[] = array('id'=>$res['id'], 'label'=>$res['label'], 'link'=>$generic ? '#/g/chiro/site/detail/'.$id : '#/chiro/site/'.$id);
                $out[] = array('id'=>null, 'label'=>'Sites', 'link'=>$generic ? '#/g/chiro/site/list' : '#/chiro/site');
        }
        return new JsonResponse(array_reverse($out));
    }
}
