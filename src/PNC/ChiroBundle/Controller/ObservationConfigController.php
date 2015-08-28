<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class ObservationConfigController extends Controller{
    // path : GET chiro/config/observation/form
    public function getFormAction(){

        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/observation/form.yml');

        return new JsonResponse($out);
    }


    // path : GET chiro/config/observation/sans-site/form
    public function getFormSsSiteAction(){

        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/observation/form_ssite.yml');

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

        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/observation/detail.yml');

        return new JsonResponse($out);
    }


    // path : GET chiro/config/observation/sans-site/detail
    public function getDetailSsSiteAction(){

        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/observation/detail_ssite.yml');
        
        return new JsonResponse($out);
    }
}
