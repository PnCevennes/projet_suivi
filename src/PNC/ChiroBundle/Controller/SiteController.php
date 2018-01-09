<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;


class SiteController extends Controller{

    // path: GET /chiro/site
    public function listAction(Request $request){
        /*
         * retourne la liste des sites "chiro"
         */
        $ss = $this->get('siteService');

        return new JsonResponse($ss->getFilteredList($request));
    }

    // path: GET /chiro/sitelist/{q}
    // retourne la liste des sites filtrés sur le nom
    public function listSimpleAction($q) {
      /*
       * Retourne la liste simplifiée des sites
       */

      $db = $this->getDoctrine()->getManager()->getConnection();
      $sql = "SELECT id, bs_nom FROM chiro.vue_chiro_site WHERE bs_nom ilike :q";
      $sql .= " ORDER BY bs_nom LIMIT 40";
      $qr = $db->prepare($sql);
      $qr->execute(array(":q" => '%'.$q.'%'));
      $sites = $qr->fetchAll();
      $out = [];
      foreach($sites as $site){
          $out[] = array(
              'id'=>$site['id'],
              'label'=>$site['bs_nom']
          );
      }
      if ($out) return new JsonResponse($out);

      return new JsonResponse(array('id'=>'', 'label'=>''), 404);
    }

    // path: GET /chiro/sitelist/{id}
    // retourne la liste des sites filtrés sur le nom
    public function getSimpleDetailAction($id) {
      /*
       * Retourne la liste simplifiée des sites
       */

      $db = $this->getDoctrine()->getManager()->getConnection();
      $sql = "SELECT id, bs_nom FROM chiro.vue_chiro_site WHERE id = :id";
      $qr = $db->prepare($sql);
      $qr->execute(array(":id" => $id));
      $sites = $qr->fetchAll();
      $out = [];
      foreach($sites as $site){
          $out = array(
              'id'=>$site['id'],
              'label'=>$site['bs_nom']
          );
      }
      if ($out) return new JsonResponse($out);

      return new JsonResponse(array('id'=>'', 'label'=>''), 404);
    }

    // path: GET /chiro/site/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'un site chiro
         */
        $ss = $this->get('siteService');

        $data = $ss->getOne($id);

        return new JsonResponse($data);
    }

    // path: PUT /chiro/site
    public function createAction(Request $req){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3,100)){
            throw new AccessDeniedHttpException();
        }
        $props = json_decode($req->getContent(), true);

        try{
            $ss = $this->get('siteService');
            return new JsonResponse($ss->create($props));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }




        return new JsonResponse(array('id'=>$site->getId()));
    }


    // path: POST /chiro/site/{id}
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3, 100)){
            throw new AccessDeniedHttpException();
        }
        $props = json_decode($req->getContent(), true);



        try{
            $ss = $this->get('siteService');
            return new JsonResponse($ss->update($id, $props));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /chiro/site/{id}
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5, 100);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        $cascade = true;

        $ss = $this->get('siteService');
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
