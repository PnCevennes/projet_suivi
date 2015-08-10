<?php

namespace Commons\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use Doctrine\ORM\Query\ResultSetMapping;

class DefaultController extends Controller
{

    // path: POST /users/login
    public function loginAction(Request $req){
        $userData = json_decode($req->getContent(), true);
        

        //FIXME usage d'une requête native : revoir mapping entité

        $mgr = $this->getDoctrine()->getConnection();
        $qr = $mgr->prepare('select a.* from utilisateurs.view_login a where identifiant=:login and pass=:pass');
        $qr->bindValue('login', $userData['login']);
        $qr->bindValue('pass', md5($userData['pass']));
        $qr->execute();
        $data = $qr->fetchAll();
        //print_r($data);

        if(!$data){
            return new JsonResponse(array('id'=>null), 403);
        }
        foreach($data as $user){
            if(!isset($out)){
                $out = $user;
                $out['apps'] = array($user['id_application']=>$user['maxdroit']);
            }
            else{
                $out['apps'][$user['id_application']] = $user['maxdroit'];
            }
        }

        // génération d'un token
        $token = md5(uniqid());
        
        $resp = new JsonResponse($out);
        $resp->headers->setCookie(new Cookie('token', $token));
        $req->getSession()->set('token', $token);
        $req->getSession()->set('user', $out);

        /*
         *
         */
        return $resp;
    }

    // path: GET /users/logout
    public function logoutAction(Request $req){
        $out = array();
        $resp = new JsonResponse($out);
        $resp->headers->setCookie(new Cookie('token', ''));
        return $resp;
    }

    // path: GET /users/name/{app}/{droit}/{q}
    // retourne la liste des utilisateurs filtrée sur le nom et le niveau de droits
    public function getUsersByNameAction($app, $droit, $q){
        $repo = $this->getDoctrine()->getRepository('CommonsUsersBundle:Login');
        $users = $repo->getLike($app, $droit, $q);
        $out = array();
        foreach($users as $user){
            $out[] = array('id'=>$user->getIdRole(), 'label'=>$user->getNomComplet());
        }
        return new JsonResponse($out);
    }

    // path: GET /users/id/{id}
    // retourne l'utilisateur identifié par l'ID fourni
    public function getUserByIdAction($id){

        $db = $this->getDoctrine()->getManager()->getConnection();

        $qr = $db->prepare("select id_role, (nom_role || ' ' || prenom_role) as nomcomplet from utilisateurs.t_roles where id_role=:id");
        $qr->bindValue('id', $id);
        $qr->execute();

        $user = $qr->fetchAll();

        if($user){
            $out = array(
                'id'=>$user[0]['id_role'],
                'label'=>$user[0]['nomcomplet']
            );
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>'', 'label'=>''), 404);
    }
}
