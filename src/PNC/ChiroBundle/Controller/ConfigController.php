<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;


class ConfigController extends Controller{


    //path : chiro/breadcrumb
    public function breadcrumbAction(Request $req){
        $entityService = $this->get('entityService');
        $view = $req->get('view');
        $id = $req->get('id');
        $generic = $req->get('generic') == "true";
        $out = array();
        try{
            switch($view){
                case 'biometrie':
                    $data = $entityService->getBcData(
                        'SELECT id as label, fk_cotx_id as next FROM chiro.subpr_observationtaxon_biometrie WHERE id=:id',
                        'id',
                        $id);
                    $out[] = array(
                        'id'=>$id, 
                        'label'=>'Biometrie n°'.$data['label'], 
                        'link'=> $generic ? '#/g/chiro/biometrie/detail/'.$id : '#/chiro/biometrie/'.$id
                    );
                    $id = $data['next'];
                case 'taxons':
                case 'taxon':
                    $data = $entityService->getBcData(
                        'SELECT cotx_nom_complet as label, fk_bv_id as next FROM chiro.pr_visite_observationtaxon WHERE id=:id',
                        'id',
                        $id);
                    $out[] = array(
                        'id'=>$id, 
                        'label'=>$data['label'], 
                        'link'=> $generic ? '#/g/chiro/taxons/detail/'.$id : '#/chiro/taxons/'.$id
                    );
                    $id = $data['next'];
                case 'validation':
                    if($view == 'validation'){
                        return new JsonResponse(array(array('id'=>null, 'label'=>'Validation', 'link'=>'#/chiro/validation')));
                    }
                case 'inventaire':
                case 'observation':
                    if(!isset($id)){
                        $out[] = array(
                            'id'=>null, 
                            'label'=>'Inventaire', 
                            'link'=> $generic ? '#/g/chiro/inventaire/list' : '#/chiro/inventaire');
                        return new JsonResponse(array_reverse($out));
                    }
                    $data = $entityService->getBcData(
                        'SELECT bv_date as label, fk_bs_id as next FROM suivi.pr_base_visite WHERE id=:id',
                        'id',
                        $id);
                    if($data['next']==null){
                        $out[] = array(
                            'id'=>$id, 
                            'label'=>implode('/', array_reverse(explode('-', $data['label']))), //transformation date Y-m-d -> d/m/Y
                            'link'=> $generic ? '#/g/chiro/inventaire/detail/'.$id : '#/chiro/inventaire/'.$id);
                        $out[] = array(
                            'id'=>null, 
                            'label'=>'Inventaire', 
                            'link'=> $generic ? '#/g/chiro/inventaire/list' : '#/chiro/inventaire');
                        return new JsonResponse(array_reverse($out));
                    }
                    $out[] = array(
                        'id'=>$id, 
                        'label'=>implode('/', array_reverse(explode('-', $data['label']))), //transformation date Y-m-d -> d/m/Y
                        'link'=> $generic ? '#/g/chiro/observation/detail/'.$id : '#/chiro/observation/'.$id);
                    $id = $data['next'];
                case 'site':
                    if(isset($id)){
                        $data = $entityService->getBcData(
                            'SELECT bs_nom as label, null as next FROM suivi.pr_base_site WHERE id=:id',
                            'id',
                            $id);
                        $out[] = array('id'=>$id, 'label'=>$data['label'], 'link'=>$generic ? '#/g/chiro/site/detail/'.$id : '#/chiro/site/'.$id);
                    }
                    $out[] = array('id'=>null, 'label'=>'Sites', 'link'=>$generic ? '#/g/chiro/site/list' : '#/chiro/site');
            }
            return new JsonResponse(array_reverse($out));

        }
        catch(DataObjectException $e){
            return new JsonResponse(array('id'=>null), 404);
        }

    }
}
