<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

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

        $out = array(
            array(
                'name'=>'ageId',
                'label'=>'Age',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesAge),
                'default'=>10
            ),
            array(
                'name'=>'sexeId',
                'label'=>'Sexe',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesSexe),
                'default'=>12
            ),
            array(
                'name'=>'biomAb',
                'label'=>'Biom AB',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomPoids',
                'label'=>'Poids',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3mf1',
                'label'=>'D3MF1',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3f2f3',
                'label'=>'D3F2F3',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3total',
                'label'=>'D3 Total',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD5',
                'label'=>'D5',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCm3sup',
                'label'=>'CM3SUP',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCm3inf',
                'label'=>'CM3INF',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCb',
                'label'=>'CB',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomLm',
                'label'=>'LM',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomOreille',
                'label'=>'Oreille',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCommentaire',
                'label'=>'Commentaires',
                'type'=>'string',
                'help'=>'',
                'options'=>array()
            ),
        );
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

        $out = array(
            array(
                'name'=>'ageId',
                'label'=>'Age',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesAge)
            ),
            array(
                'name'=>'sexeId',
                'label'=>'Sexe',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesSexe)
                ),
            array(
                'name'=>'biomPoids',
                'label'=>'Poids',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
                ),
            );

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

        $out = array(
            array(
                'name'=>'ageId',
                'label'=>'Age',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesAge)
            ),
            array(
                'name'=>'sexeId',
                'label'=>'Sexe',
                'type'=>'select',
                'help'=>'',
                'options'=>array('choices'=>$typesSexe)
            ),
            array(
                'name'=>'biomAb',
                'label'=>'Biom AB',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomPoids',
                'label'=>'Poids',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3mf1',
                'label'=>'D3MF1',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3f2f3',
                'label'=>'D3F2F3',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD3total',
                'label'=>'D3 Total',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomD5',
                'label'=>'D5',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCm3sup',
                'label'=>'CM3SUP',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCm3inf',
                'label'=>'CM3INF',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCb',
                'label'=>'CB',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomLm',
                'label'=>'LM',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomOreille',
                'label'=>'Oreille',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
            array(
                'name'=>'biomCommentaire',
                'label'=>'Commentaires',
                'type'=>'num',
                'help'=>'',
                'options'=>array()
            ),
        );

        return new JsonResponse($out);
    }

}
