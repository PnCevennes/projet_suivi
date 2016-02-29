<?php

namespace PNC\PatrimoineBatiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;


class SiteConfigController extends Controller{
    // path : GET chiro/config/site/form
    public function getFormAction(){

        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/site/form.yml');
        return new JsonResponse($out);
    }

    // path : GET chiro/config/site/list
    public function getListAction(){
        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/site/list.yml');
        /*$file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/list.yml');
        $out = Yaml::parse($file);
         */
        return new JsonResponse($out);
    }

    // path : GET chiro/config/site/detail
    public function getDetailAction(){
        $conf = $this->get('configService');
        $out = $conf->get_config(__DIR__ . '/../Resources/clientConf/site/detail.yml');
        return new JsonResponse($out);
    }
}
