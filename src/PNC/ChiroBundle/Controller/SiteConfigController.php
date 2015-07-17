<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;


class SiteConfigController extends Controller{
    // path : GET chiro/config/site/form
    public function getFormAction(){

        /*
         * récupération du vocabulaire type lieu
         */
        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'typeId'){
                    $field['options']['choices'] = $thesaurus->get_list(7);
                    $field['default'] = 37;
                }
                if($field['name'] == 'siteFrequentation'){
                    $field['options']['choices'] = $thesaurus->get_list(11);
                    $field['default'] = 59;
                }
                if($field['name'] == 'siteMenace'){
                    $field['options']['choices'] = $thesaurus->get_list(10);
                    $field['default'] = 64;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/site/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/list.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET chiro/config/site/detail
    public function getDetailAction(){
        /*
         * récupération du vocabulaire type lieu
         */
        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/detail.yml');
        $out = Yaml::parse($file);
       
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if($field['name'] == 'typeId'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $thesaurus->get_list(7);
                }
                if($field['name'] == 'siteFrequentation'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $thesaurus->get_list(11);
                }
                if($field['name'] == 'siteMenace'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $thesaurus->get_list(10);
                }
            }
        }

        return new JsonResponse($out);
    }
}
