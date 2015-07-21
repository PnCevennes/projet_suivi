<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

class ObservationController extends Controller{

    // path: GET /chiro/observation
    public function listAction(Request $request){
        /*
         * retourne la liste complete des observations
         */
        $os = $this->get('observationService');
        /*
        $out = array();
        foreach( as $item){
            $geoJson = array(
                'type'=>'Feature',
                'geometry'=>$item['geom'],
                'properties'=>$item);
            $out[] = $geoJson;
        }
        */
        $out = $os->getFilteredList($request);
        return new JsonResponse($out);
    }

    // path: GET /chiro/observation/site/{id}
    public function listSiteAction($id){
        /*
         * retourne la liste des observations associées à un site
         */
        $os = $this->get('observationService');
        
        return new JsonResponse($os->getList($id));
    }

    // path: GET /chiro/observation/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'une observation
         */
        $os = $this->get('observationService');
        $obs = $os->getOne($id);

        if(!$obs){
            return new JsonResponse(array('id'=>$id), 404);
        }
        return new JsonResponse($obs);
    }

    // path: PUT /chiro/observation
    public function createAction(Request $req){

        // vérification droits utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(2)){
            throw new AccessDeniedHttpException();
        }

        $data = json_decode($req->getContent(), true);

        $os = $this->get('observationService');
        try{
            return new JsonResponse($os->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }

    // path: POST /chiro/observation/{id}
    public function updateAction(Request $req, $id){
        // vérification droits utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            if(!$user->isOwner($obs->getNumerisateurId())){
                throw new AccessDeniedHttpException();
            }
        }

        $data = json_decode($req->getContent(), true);

        $os = $this->get('observationService');
        try{
            return new JsonResponse($os->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }

    // path: DELETE /chiro/observation/{id}
    public function deleteAction($id){
        // vérification droits utilisateur
        $user = $this->get('userServ');
        $delete = false;
        $cascade = false;

        $os = $this->get('observationService');
        $obs = $os->getOne($id);
        if(!$obs){
            return new JsonResponse(array('id'=>$id), 404);
        }

        if($user->checkLevel(5)){
            $delete = true;
            $cascade = true;
        }
        if($user->checkLevel(3)){
            $delete = true;
            if(!$user->isOwner($obs['numerisateurId'])){
                $cascade = true;
            }
        }
        if($user->checkLevel(2) && $user->isOwner($obs['numerisateurId'])){
            $delete = true;
        }

        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        try{
            $res = $os->remove($id, $cascade);
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
