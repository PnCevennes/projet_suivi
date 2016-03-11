<?php

namespace PNC\PatrimoineBatiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

class SiteController extends Controller{

    // path: GET /patrimoinebati/site
    public function listAction(Request $request){
        /*
         * retourne la liste des sites "patrimoinebati"
         */
        $ss = $this->get('pbSitesService');

        return new JsonResponse($ss->getFilteredList($request));
    }


    // path: GET /patrimoinebati/site/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'un site patrimoinebati
         */
        $ss = $this->get('pbSitesService');

        return new JsonResponse($ss->getOne($id));
    }

    // path: PUT /patrimoinebati/site
    public function createAction(Request $req){

        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $props = json_decode($req->getContent(), true);

        try{
            $ss = $this->get('pbSitesService');
            return new JsonResponse($ss->create($props));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }




        return new JsonResponse(array('id'=>$site->getId()));
    }


    // path: POST /patrimoinebati/site/{id}
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $props = json_decode($req->getContent(), true);
        try{
            $ss = $this->get('pbSitesService');
            return new JsonResponse($ss->update($id, $props));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /patrimoinebati/site/{id}
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }
        $cascade = true;
        $ss = $this->get('pbSitesService');
        try{
            $res = $ss->remove($id, $cascade);
        }
        catch(CascadeException $e){
            throw new AccessDeniedHttpException();
        }
        if(!$res){
            return new JsonResponse(array('id'=>$id), 404);
        }
        return new JsonResponse(array('id'=>$id));
    }
}
