<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;

class ObsTaxonController extends Controller
{
    // path: GET chiro/obs_taxon/observation/{obs_id}
    public function listAction($obs_id=null){
        /*
         * retourne la liste des observations taxon associées à une obs
         */
        $ts = $this->get('taxonService');
        return new JsonResponse($ts->getList($obs_id));
    }

    // path: GET chiro/obs_taxon/{id}
    public function detailAction($id){
        /*
         * retourne une observation taxon identifiée par ID
         */
        $ts = $this->get('taxonService');
        $out = $ts->getOne($id);
        if($out){
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>$id), 404);
    }


    // path: PUT chiro/obs_taxon
    public function createAction(Request $req){

        // vérification droits utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(2)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        $ts = $this->get('taxonService');
        try{
            return new JsonResponse($ts->create($data));
        }
        catch(DataObjectException $e){
            $errs = $obsTx->errors();
            return new JsonResponse($errs, 400);
        }


    }

    // path: POST chiro/obs_taxon/{id}
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        // vérification droits utilisateur
        if(!$user->checkLevel(3)){
            //TODO verification proprio
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);

        $ts = $this->get('taxonService');

        try{
            $res = $ts->update($id, $data);
            if(!$res){
                return new JsonResponse(array('id'=>$id), 404);
            }
            return new JsonResponse($res);
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }

    // path: DELETE chiro/obs_taxon/{id}
    public function deleteAction($id){
        $user = $this->get('userServ');
        // vérification droits utilisateur
        if(!$user->checkLevel(3)){
            //TODO verification proprio
            throw new AccessDeniedHttpException();
        }

        $ts = $this->get('taxonService');
        if($ts->remove($id)){
            return new JsonResponse(array('id'=>$id));
        }
        return new JsonResponse(array('id'=>$id), 404);
    }
}


