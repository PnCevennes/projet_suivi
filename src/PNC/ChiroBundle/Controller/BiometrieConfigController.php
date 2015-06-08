<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Yaml\Yaml;

class BiometrieConfigController extends Controller{

    // path : GET chiro/config/biometrie/form
    public function getFormAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $tSexe = $repo->findBy(array('id_type'=>2));
        $typesSexe = array();
        foreach($tSexe as $tl){
            if($tl->getFkParent() != 0){
                $typesSexe[] = $norm->normalize($tl, array());
            }
        }

        $tAge = $repo->findBy(array('id_type'=>1));
        $typesAge= array();
        foreach($tAge as $tl){
            if($tl->getFkParent() != 0){
                $typesAge[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'ageId'){
                    $field['options']['choices'] = $typesAge;
                    $field['default'] = 10;
                }
                if($field['name'] == 'sexeId'){
                    $field['options']['choices'] = $typesSexe;
                    $field['default'] = 12;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/biometrie/form/many
    public function getFormManyAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $tSexe = $repo->findBy(array('id_type'=>2));
        $typesSexe = array(array('id'=>null, 'libelle'=>''));
        foreach($tSexe as $tl){
            if($tl->getFkParent() != 0){
                $typesSexe[] = $norm->normalize($tl, array());
            }
        }

        $tAge = $repo->findBy(array('id_type'=>1));
        $typesAge= array(array('id'=>null, 'libelle'=>''));
        foreach($tAge as $tl){
            if($tl->getFkParent() != 0){
                $typesAge[] = $norm->normalize($tl, array());
            }
        }
 
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/form_many.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'ageId'){
                $field['options']['choices'] = $typesAge;
                $field['default'] = 10;
            }
            if($field['name'] == 'sexeId'){
                $field['options']['choices'] = $typesSexe;
                $field['default'] = 12;
            }
        }

        return new JsonResponse($out);
    }

    // path: GET chiro/config/biometrie/list
    public function getListAction(){

        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $tSexe = $repo->findBy(array('id_type'=>2));
        $typesSexe = array();
        foreach($tSexe as $tl){
            if($tl->getFkParent() != 0){
                $typesSexe[] = $norm->normalize($tl, array());
            }
        }

        $tAge = $repo->findBy(array('id_type'=>1));
        $typesAge= array();
        foreach($tAge as $tl){
            if($tl->getFkParent() != 0){
                $typesAge[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'ageId'){
                $field['options']['choices'] = $typesAge;
                $field['default'] = 10;
            }
            if($field['name'] == 'sexeId'){
                $field['options']['choices'] = $typesSexe;
                $field['default'] = 12;
            }
        }

        return new JsonResponse($out);
    }

    // path: GET chiro/config/biometrie/detail
    public function getDetailAction(){

        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $tSexe = $repo->findBy(array('id_type'=>2));
        $typesSexe = array();
        foreach($tSexe as $tl){
            if($tl->getFkParent() != 0){
                $typesSexe[] = $norm->normalize($tl, array());
            }
        }

        $tAge = $repo->findBy(array('id_type'=>1));
        $typesAge= array();
        foreach($tAge as $tl){
            if($tl->getFkParent() != 0){
                $typesAge[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/biometrie/detail.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'ageId'){
                    $field['options']['choices'] = $typesAge;
                }
                if($field['name'] == 'sexeId'){
                    $field['options']['choices'] = $typesSexe;
                }
            }
        }

        return new JsonResponse($out);
    }

}
