<?php

namespace Commons\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;



class DefaultController extends Controller
{

    // path: POST /users/login
    public function loginAction(Request $req){
        $userData = json_decode($req->getContent(), true);

        $repo = $this->getDoctrine()->getRepository('CommonsUsersBundle:Login');
        $norm = $this->get('normalizer');

        $user = $repo->findOneBy(array(
            'identifiant'=>$userData['login'],
            'pass'=>md5($userData['pass']),
            'id_application'=>$userData['idApp'],
            )
        );

        if(!$user){
            return new JsonResponse(array('id'=>null), 403);
        }
        $out = $norm->normalize($user);

        // génération d'un token
        $token = md5(uniqid());
        
        $resp = new JsonResponse($out);
        $resp->headers->setCookie(new Cookie('token', $token));
        $req->getSession()->set('token', $token);
        $req->getSession()->set('user', $user);

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
        $repo = $this->getDoctrine()->getRepository('CommonsUsersBundle:Login');
        $user = $repo->findOneBy(array('id_role'=>$id));
        if($user){
            $out = array(
                'id'=>$user->getIdRole(),
                'label'=>$user->getNomComplet()
            );
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>'', 'label'=>''), 404);
    }
}
