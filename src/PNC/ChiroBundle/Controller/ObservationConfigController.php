<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class ObservationConfigController extends Controller{
    // path : GET chiro/config/observation/form
    public function getFormAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/form.yml');
        $out = Yaml::parse($file);

       
        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/sans-site/form
    public function getFormSsSiteAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/form_ssite.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }


    // path : GET chiro/config/observation/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/list.yml');
        $out = Yaml::parse($file);
        
        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/sans-site/list
    public function getListSsSiteAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/list_ssite.yml');
        $out = Yaml::parse($file);
        
        return new JsonResponse($out);
    }
        
    // path : GET chiro/config/observation/detail
    public function getDetailAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/detail.yml');
        $out = Yaml::parse($file);
        
        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/sans-site/detail
    public function getDetailSsSiteAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/detail_ssite.yml');
        $out = Yaml::parse($file);
        
        return new JsonResponse($out);
    }
}
