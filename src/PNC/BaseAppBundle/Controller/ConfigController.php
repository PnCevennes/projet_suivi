<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller{
    

    public function indexAction(){
        return new BinaryFileResponse('suivi.html');
    }

    // path: GET /apps
    public function getAppsAction(){
        return new JsonResponse(array(
            array('id'=>'1', 'name'=>'chiro'),
            //array('id'=>'2', 'name'=>'cheveche'),
        ));
    }

    // path: POST /observateurs
    public function getObservateursAction(Request $req){
        $input = json_decode($req->getContent(), true);
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observateurs');
        if(isset($input['id'])){
            $resp = $repo->findOneBy(array('id_role'=>$input['id']));
                $out = array(
                    'label'=>$resp->getNomRole() . ' ' . $resp->getPrenomRole(), 
                    'id'=>$resp->getIdRole());
            return new JsonResponse($out);
        }
        else{
            $resp = $repo->getLike($input['label']);
            $out = array();
            foreach($resp as $item){
                $out[] = array(
                    'label'=>$item->getNomRole() . ' ' . $item->getPrenomRole(), 
                    'id'=>$item->getIdRole());
            }
        }
        return new JsonResponse($out);
    }
}
