<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    // path: PUT chiro/biometrie/many
    public function createManyAction(Request $req){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $bs = $this->get('biometrieService');
        $data = json_decode($req->getContent(), true);
        $db = $this->get('doctrine');
        $db->getConnection()->beginTransaction();
        $manager = $db->getManager();
        try{
            foreach($data['__items__'] as $item){
                $item['obsTxId'] = $data['refId'];
                $item['biomCommentaire'] = '';
                $bs->create($item, $manager, false);
            }
        }
        catch(DataObjectException $e){
            $db->getConnection()->rollback();
            $errs = $e->getErrors();
            return new JsonResponse($errs, 400);
        }
        $db->getConnection()->commit();
        return new JsonResponse(array('id'=>$data['refId']));

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
            $res = $bs->update($id, $data);
            if(!$res){
                return new JsonResponse(array('id'=>$id), 404);
            }
            return new JsonResponse($res);
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
        return new JsonResponse(array('id'=>$id), 404);
    }
}


