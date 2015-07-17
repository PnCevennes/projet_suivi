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
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');

        // Statut validation
        $types = $repo->findBy(array('id_type'=>9));
        $typesVal = array(array('id'=>0, 'libelle'=>'Tout statut'));
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesVal[] = $norm->normalize($tl, array());
            }
        }

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
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');

        // Statut validation
        $types = $repo->findBy(array('id_type'=>9));
        $typesVal = array();
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesVal[] = $norm->normalize($tl, array());
            }
        }

        // Activité
        $acts = $repo->findBy(array('id_type'=>5));
        $typeAct = array(array('id'=>null, 'libelle'=>''));
        foreach($acts as $tl){
            if($tl->getFkParent() != 0){
                $typeAct[] = $norm->normalize($tl, array());
            }
        }

        // Preuves de reproduction
        $prvs = $repo->findBy(array('id_type'=>6));
        $typePrv = array(array('id'=>null, 'libelle'=>''));
        foreach($prvs as $tl){
            if($tl->getFkParent() != 0){
                $typePrv[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/form.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'obsObjStatusValidation'){
                    $field['options']['choices'] = $typesVal;
                    $field['default'] = 56;
                }
                if($field['name'] == 'actId'){
                    $field['options']['choices'] = $typeAct;
                    $field['default'] = null;
                    //$field['default'] = 25;
                }
                if($field['name'] == 'prvId'){
                    $field['options']['choices'] = $typePrv;
                    $field['default'] = null;
                    //$field['default'] = 32;
                }
            }
        }

        return new JsonResponse($out);
    }
    
    // path : GET chiro/config/obstaxon/form/many
    public function getFormManyAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $types = $repo->findBy(array('id_type'=>9));

        // Activité
        $acts = $repo->findBy(array('id_type'=>5));
        $typeAct = array(array('id'=>null, 'libelle'=>''));
        foreach($acts as $tl){
            if($tl->getFkParent() != 0){
                $typeAct[] = $norm->normalize($tl, array());
            }
        }

        // Preuves de reproduction
        $prvs = $repo->findBy(array('id_type'=>6));
        $typePrv = array(array('id'=>null, 'libelle'=>''));
        foreach($prvs as $tl){
            if($tl->getFkParent() != 0){
                $typePrv[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/form_many.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'actId'){
                $field['options']['choices'] = $typeAct;
                $field['default'] = null;
            }
            if($field['name'] == 'prvId'){
                $field['options']['choices'] = $typePrv;
                $field['default'] = null;
            }
        }

        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/detail
    public function getDetailAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $types = $repo->findBy(array('id_type'=>9));
        $typesVal = array();
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesVal[] = $norm->normalize($tl, array());
            }
        }


        // Activité
        $acts = $repo->findBy(array('id_type'=>5));
        $typeAct = array();
        foreach($acts as $tl){
            if($tl->getFkParent() != 0){
                $typeAct[] = $norm->normalize($tl, array());
            }
        }

        // Preuves de reproduction
        $prvs = $repo->findBy(array('id_type'=>6));
        $typePrv = array();
        foreach($prvs as $tl){
            if($tl->getFkParent() != 0){
                $typePrv[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/detail.yml');
        $out = Yaml::parse($file);

        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'obsObjStatusValidation'){
                    $field['options']['choices'] = $typesVal;
                }
                if($field['name'] == 'actId'){
                    $field['options']['choices'] = $typeAct;
                }
                if($field['name'] == 'prvId'){
                    $field['options']['choices'] = $typePrv;
                }
            }
        }



        return new JsonResponse($out);
    }

    // path : GET chiro/config/obstaxon/list
    public function getListAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $types = $repo->findBy(array('id_type'=>9));
        $typesVal = array();
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesVal[] = $norm->normalize($tl, array());
            }
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/obsTaxon/list.yml');
        $out = Yaml::parse($file);


        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'obsObjStatusValidation'){
                $field['options']['choices'] = $typesVal;
            }
        }
        return new JsonResponse($out);
    }
}


