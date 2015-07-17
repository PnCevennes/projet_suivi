<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class ObsTaxonConfigController extends Controller{

    // path: GET chiro/taxons/id/{id}
    public function getTaxonsIdAction($id){
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Taxons');
        $resp = $repo->findOneBy(array('cd_nom'=>$id));
        if($resp){
            return new JsonResponse(array('id'=>$id, 'label'=>$resp->getNomComplet()));
        }
        return new JsonResponse(array());
    }

    // path: GET chiro/taxons/{qr}
    public function getTaxonsAction($qr){
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Taxons');
        $resp = $repo->getLike($qr);
        $out = array();
        foreach($resp as $item){
            $out[] = array('id'=>$item->getCdNom(), 'label'=>$item->getNomComplet());
        }
        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/validation
    public function getValidationAction(){

        // Statut validation
        $thesaurus = $this->get('thesaurusService');
        $typesVal = $thesaurus->get_list(9);
        $typesVal[0]['libelle'] = 'Tout statut';

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/validation.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'obsObjStatusValidation'){
                $field['options']['choices'] = $typesVal;
                $field['default'] = 0;
            }
        }
        foreach($out['filtering']['fields'] as &$field){
            if($field['name'] == 'obs_obj_status_validation'){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                $field['options']['choices'] = $typesVal;
                $field['default'] = 0;
            }
        }
        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/form
    public function getFormAction(){
        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'obsObjStatusValidation'){
                    $field['options']['choices'] = $thesaurus->get_list(9, false);
                    $field['default'] = 55;
                }
                if($field['name'] == 'actId'){
                    $field['options']['choices'] = $thesaurus->get_list(5);
                    $field['default'] = 0;
                    //$field['default'] = 25;
                }
                if($field['name'] == 'prvId'){
                    $field['options']['choices'] = $thesaurus->get_list(6);
                    $field['default'] = 0;
                    //$field['default'] = 32;
                }
            }
        }

        return new JsonResponse($out);
    }
    
    // path : GET chiro/config/obstaxon/form/many
    public function getFormManyAction(){

        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/form_many.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'actId'){
                $field['options']['choices'] = $thesaurus->get_list(5);
                $field['default'] = 0;
                //$field['default'] = 25;
            }
            if($field['name'] == 'prvId'){
                $field['options']['choices'] = $thesaurus->get_list(6);
                $field['default'] = 0;
                //$field['default'] = 32;
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/detail
    public function getDetailAction(){
        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/detail.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'obsObjStatusValidation'){
                    $field['options']['choices'] = $thesaurus->get_list(9, false);
                }
                if($field['name'] == 'actId'){
                    $field['options']['choices'] = $thesaurus->get_list(5);
                }
                if($field['name'] == 'prvId'){
                    $field['options']['choices'] = $thesaurus->get_list(6);
                }
            }
        }



        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/list
    public function getListAction(){
        $thesaurus = $this->get('thesaurusService');

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/list.yml');
        $out = Yaml::parse($file);


        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'obsObjStatusValidation'){
                $field['options']['choices'] = $thesaurus->get_list(9, false);
            }
        }
        return new JsonResponse($out);
    }
}


