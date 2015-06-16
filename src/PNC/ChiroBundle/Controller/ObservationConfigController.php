<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class ObservationConfigController extends Controller{
    // path : GET chiro/config/observation/form
    public function getFormAction(){
        $norm = $this->get('normalizer');

        // Mode d'observation
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/form.yml');
        $out = Yaml::parse($file);
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'modId'){
                    $field['options']['choices'] = $typeMod;
                    $field['default'] = 18;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/sans-site/form
    public function getFormSsSiteAction(){
        $norm = $this->get('normalizer');

        // Mode d'observation
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/form_ssite.yml');
        $out = Yaml::parse($file);
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'modId'){
                    $field['options']['choices'] = $typeMod;
                    $field['default'] = 18;
                }
            }
        }

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
        $norm = $this->get('normalizer');

        // Mode d'observation
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/detail.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'modId'){
                    $field['options']['choices'] = $typeMod;
                }
            }
        }
        
        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/sans-site/detail
    public function getDetailSsSiteAction(){
        $norm = $this->get('normalizer');

        // Mode d'observation
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/observation/detail_ssite.yml');
        $out = Yaml::parse($file);
        
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'modId'){
                    $field['options']['choices'] = $typeMod;
                }
            }
        }
        
        return new JsonResponse($out);
    }
}
