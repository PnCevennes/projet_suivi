<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller{
    
    // path: GET /apps
    public function getAppsAction(){
        return new JsonResponse(array(
            array('id'=>'1', 'name'=>'chiro'),
            //array('id'=>'2', 'name'=>'cheveche'),
        ));
    }
}
