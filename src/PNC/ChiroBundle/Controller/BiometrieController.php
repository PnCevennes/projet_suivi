<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;

use PNC\ChiroBundle\Entity\Biometrie;

class BiometrieController extends Controller
{
    // path: GET chiro/biometrie/taxon/{otx_id}
    public function listAction($otx_id=null){
        $bs = $this->get('biometrieService');
        
        return new JsonResponse($bs->getList($otx_id));
    }

    // path: GET chiro/biometrie/{id}
    public function detailAction($id){
        $bs = $this->get('biometrieService');
        $data = $bs->getOne($id);

        if($data){
            return new JsonResponse($data);
        }
        return new JsonResponse(array('id'=>$id), 404);
    }

    // path: PUT chiro/biometrie
    public function createAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $bs = $this->get('biometrieService');
        $data = json_decode($req->getContent(), true);
        try{
            return new JsonResponse($bs->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }

    // path: POST chiro/biometrie/{id}
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        $bs = $this->get('biometrieService');

        try{
            return new JsonResponse($bs->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }

    // path: DELETE chiro/biometrie/{id}
    public function deleteAction($id){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $bs = $this->get('biometrieService');
        if($bs->remove($id)){
            return new JsonResponse(array('id'=>$id));
        }
        else{
            return new JsonResponse(array('id'=>$id), 400);
        }
    }
}


