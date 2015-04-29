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
            'groups'=>array(
                array(
                    'name'=>'Mesures',
                    'fields'=>array(
                        array(
                            'name'=>'id',
                            'type'=>'hidden',
                        ),
                        array(
                            'name'=>'obsTxId',
                            'type'=>'hidden',
                        ),
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
                            'type'=>'num',
                            'help'=>"Mesure de l'avant bras",
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomPoids',
                            'label'=>'Poids',
                            'type'=>'num',
                            'help'=>'Poids de la bebette',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomD3mf1',
                            'label'=>'D3MF1',
                            'type'=>'num',
                            'help'=>"Mesure du 3ème doigt, métacarpe + 1ere phalange",
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomD3f2f3',
                            'label'=>'D3F2F3',
                            'type'=>'num',
                            'help'=>'Mesure du 3ème doigt, 2ème et 3ème phalange',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomD3total',
                            'label'=>'D3 Total',
                            'type'=>'num',
                            'help'=>'Longueur totale du 3ème doigt',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomD5',
                            'label'=>'D5',
                            'type'=>'num',
                            'help'=>'Mesure du 5ème doigt',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomCm3sup',
                            'label'=>'CM3SUP',
                            'type'=>'num',
                            'help'=>'Mesure canine - 3ème molaire (mandibule supérieure)',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomCm3inf',
                            'label'=>'CM3INF',
                            'type'=>'num',
                            'help'=>'Mesure canine - 3ème molaire (mandibule inférieure)',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomCb',
                            'label'=>'CB',
                            'type'=>'num',
                            'help'=>'Mesure condylobasale',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomLm',
                            'label'=>'LM',
                            'type'=>'num',
                            'help'=>'Mesure mandibule inférieure',
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomOreille',
                            'label'=>'Oreille',
                            'type'=>'num',
                            'help'=>"Mesure de l'oreille",
                            'options'=>array('step'=>'0.0001')
                        ),
                        array(
                            'name'=>'biomCommentaire',
                            'label'=>'Commentaires',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                    ),
                ),
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
            'title'=>'Biométries',
            'emptyMsg'=>'Aucune biométrie',
            'createBtnLabel'=>'Nouvelle biométrie',
            'createUrl'=>'#/chiro/edit/biometrie/taxon/',
            'fields'=>array(
                array(
                    'name'=>'id',
                    'label'=>'Numéro',
                    'type'=>'link',
                    'url'=>'#/chiro/biometrie/',
                    'ref'=>'id',
                ),
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
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                    ),
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
            'editAccess'=>3,
            'groups'=>array(
                array(
                    'name'=>'Biométrie',
                    'fields'=>array(
                        array(
                            'name'=>'id',
                            'type'=>'hidden',
                            'options'=>array()
                        ),
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
                    ),
                ),
            ),
        );

        return new JsonResponse($out);
    }

}
