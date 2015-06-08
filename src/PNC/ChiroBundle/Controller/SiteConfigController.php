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
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $typeL = $repo->findBy(array('id_type'=>7));
        $typesLieu = array();
        foreach($typeL as $tl){
            if($tl->getFkParent() != 0){
                $typesLieu[] = $norm->normalize($tl, array());
            }
        }

        $typeM = $repo->findBy(array('id_type'=>11));
        $typesMenaces = array();
        foreach($typeM as $tl){
            if($tl->getFkParent() != 0){
                $typesMenaces[] = $norm->normalize($tl, array());
            }
        }

        $typeF = $repo->findBy(array('id_type'=>10));
        $typesFrequentation = array();
        foreach($typeF as $tl){
            if($tl->getFkParent() != 0){
                $typesFrequentation[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'typeId'){
                    $field['options']['choices'] = $typesLieu;
                    $field['default'] = 37;
                }
                if($field['name'] == 'siteFrequentation'){
                    $field['options']['choices'] = $typesFrequentation;
                    $field['default'] = 59;
                }
                if($field['name'] == 'siteMenace'){
                    $field['options']['choices'] = $typesMenaces;
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
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $types = $repo->findBy(array('id_type'=>7));
        $typesLieu = array();
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesLieu[] = $norm->normalize($tl, array());
            }
        }

        $typeM = $repo->findBy(array('id_type'=>11));
        $typesMenaces = array();
        foreach($typeM as $tl){
            if($tl->getFkParent() != 0){
                $typesMenaces[] = $norm->normalize($tl, array());
            }
        }

        $typeF = $repo->findBy(array('id_type'=>10));
        $typesFrequentation = array();
        foreach($typeF as $tl){
            if($tl->getFkParent() != 0){
                $typesFrequentation[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/site/detail.yml');
        $out = Yaml::parse($file);
       
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if($field['name'] == 'typeId'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $typesLieu;
                }
                if($field['name'] == 'siteFrequentation'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $typesFrequentation;
                }
                if($field['name'] == 'siteMenace'){
                    if(!isset($field['options'])){
                        $field['options'] = array();
                    }
                    $field['options']['choices'] = $typesMenaces;
                }
            }
        }

        return new JsonResponse($out);
    }
}
