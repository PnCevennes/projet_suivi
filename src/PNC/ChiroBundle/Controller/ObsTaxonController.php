<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

class ObsTaxonController extends Controller
{
    // path: GET chiro/obs_taxon/observation/{obs_id}
    public function listAction(Request $request, $obs_id=null){
        /*
         * retourne la liste des observations taxon associées à une obs
         */
        $ts = $this->get('taxonService');
        return new JsonResponse($ts->getFilteredList($request, $obs_id));
    }


    // path: GET chiro/obs_taxon
    public function listTaxonsAction(Request $req){
        $ts = $this->get('taxonService');
        return new JsonResponse($ts->getFilteredList($req));
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

    // path: PUT chiro/obs_taxon/many
    public function createManyAction(Request $req){

        // vérification droits utilisateur
        $user = $this->get('userServ');
        $ts = $this->get('taxonService');
        if(!$user->checkLevel(2)){
            throw new AccessDeniedHttpException();
        }
        $in_data = json_decode($req->getContent(), true);
        $db = $this->get('doctrine');
        $db->getConnection()->beginTransaction();
        $manager = $db->getManager();
        $ids = array();
        try{
            foreach($in_data['__items__'] as $item){
                $item['fkBvId'] = $in_data['refId'];
                $item['metaNumerisateurId'] = $user->getUser()['id_role'];
                $item['cotxObjStatusValidation'] = 55;
                $item['cotxCommentaire'] = '';
                $item['cotxValidateurId'] = null;
                $res = $ts->create($item, $manager, false);
                $ids[] = $res['id'];
            }
        }
        catch(DataObjectException $e){
            $db->getConnection()->rollback();
            $errs = $e->getErrors();
            return new JsonResponse($errs, 400);
        }
        $db->getConnection()->commit();
        return new JsonResponse(array('ids'=>$ids));
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
        $delete = false;
        $cascade = false;

        $ts = $this->get('taxonService');
        $obs = $ts->getOne($id);
        if(!$obs){
            return new JsonResponse(array('id'=>$id), 404);
        }
        // vérification droits utilisateur
        if($user->checkLevel(5)){
            $delete = true;
            $cascade = true;
        }
        elseif($user->checkLevel(3) && $user->isOwner($obs['numId'])){
            $delete = true;
            $cascade = true;
        }
        elseif($user->checkLevel(2) && $user->isOwner($obs['numId'])){
            $delete = true;
        }

        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        try{
            $res = $ts->remove($id, $cascade);
        }
        catch(CascadeException $e){
            return new JsonResponse(array('id'=>$id), 403);
        }
        if(!$res){
            return new JsonResponse(array('id'=>$id), 404);
        }
        return new JsonResponse(array('id'=>$id));
    }

    // path: POST chiro/validate_taxon
    public function validateAction(Request $req){
        $user = $this->get('userServ');
        $data = json_decode($req->getContent(), true);
        if(!$user->checkLevel(5)){
            throw new AccessDeniedHttpException();
        }
        $ts = $this->get('taxonService');
        try{
            $ts->setValidationStatus($data, $user->getUser());
            return new JsonResponse($data);
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }
}


