<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class BiometrieConfigController extends Controller{

    // path : GET chiro/config/biometrie/form
    public function getFormAction(){

        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'ageId'){
                    $field['options']['choices'] = $thesaurus->get_list(1);
                    $field['default'] = 0;
                }
                if($field['name'] == 'sexeId'){
                    $field['options']['choices'] = $thesaurus->get_list(2);
                    $field['default'] = 0;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/biometrie/form/many
    public function getFormManyAction(){

        $thesaurus = $this->get('thesaurusService');
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/form_many.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'ageId'){
                $field['options']['choices'] = $thesaurus->get_list(1);
                $field['default'] = 0;
            }
            if($field['name'] == 'sexeId'){
                $field['options']['choices'] = $thesaurus->get_list(2);
                $field['default'] = 0;
            }
        }

        return new JsonResponse($out);
    }

    // path: GET chiro/config/biometrie/list
    public function getListAction(){

        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'ageId'){
                $field['options']['choices'] = $thesaurus->get_list(1);
            }
            if($field['name'] == 'sexeId'){
                $field['options']['choices'] = $thesaurus->get_list(2);
            }
        }

        return new JsonResponse($out);
    }

    // path: GET chiro/config/biometrie/detail
    public function getDetailAction(){

        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/detail.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'ageId'){
                    $field['options']['choices'] = $thesaurus->get_list(1);
                }
                if($field['name'] == 'sexeId'){
                    $field['options']['choices'] = $thesaurus->get_list(2);
                }
            }
        }

        return new JsonResponse($out);
    }

}
