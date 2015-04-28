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
}
