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
            'deleteAccess'=>3,
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
                            'label'=>'Biom AB (mm)',
                            'type'=>'num',
                            'help'=>"Mesure de l'avant bras",
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomPoids',
                            'label'=>'Poids (g)',
                            'type'=>'num',
                            'help'=>'Poids de la bebette',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomD3mf1',
                            'label'=>'D3MF1 (mm)',
                            'type'=>'num',
                            'help'=>"Mesure du 3ème doigt, métacarpe + 1ere phalange",
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomD3f2f3',
                            'label'=>'D3F2F3 (mm)',
                            'type'=>'num',
                            'help'=>'Mesure du 3ème doigt, 2ème et 3ème phalange',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomD3total',
                            'label'=>'D3 Total (mm)',
                            'type'=>'num',
                            'help'=>'Longueur totale du 3ème doigt',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomD5',
                            'label'=>'D5 (mm)',
                            'type'=>'num',
                            'help'=>'Mesure du 5ème doigt',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomCm3sup',
                            'label'=>'CM3SUP (mm)',
                            'type'=>'num',
                            'help'=>'Mesure canine - 3ème molaire (mandibule supérieure)',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomCm3inf',
                            'label'=>'CM3INF (mm)',
                            'type'=>'num',
                            'help'=>'Mesure canine - 3ème molaire (mandibule inférieure)',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomCb',
                            'label'=>'CB (mm)',
                            'type'=>'num',
                            'help'=>'Mesure condylobasale',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomLm',
                            'label'=>'LM (mm)',
                            'type'=>'num',
                            'help'=>'Mesure mandibule inférieure',
                            'options'=>array('step'=>'0.01')
                        ),
                        array(
                            'name'=>'biomOreille',
                            'label'=>'Oreille (mm)',
                            'type'=>'num',
                            'help'=>"Mesure de l'oreille",
                            'options'=>array('step'=>'0.01')
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

        $out = array(
            'title'=>'Ajout rapide de biométries',
            'fields'=>array(
                array(
                    'name'=>'ageId',
                    'label'=>'Age',
                    'type'=>'select',
                    'help'=>'',
                    'options'=>array(
                        'required'=>true,
                        'choices'=>$typesAge),
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
                    'label'=>'Biom AB (mm)',
                    'type'=>'num',
                    'help'=>"Mesure de l'avant bras",
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomPoids',
                    'label'=>'Poids (g)',
                    'type'=>'num',
                    'help'=>'Poids de la bebette',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomD3mf1',
                    'label'=>'D3MF1 (mm)',
                    'type'=>'num',
                    'help'=>"Mesure du 3ème doigt, métacarpe + 1ere phalange",
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomD3f2f3',
                    'label'=>'D3F2F3 (mm)',
                    'type'=>'num',
                    'help'=>'Mesure du 3ème doigt, 2ème et 3ème phalange',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomD3total',
                    'label'=>'D3 Total (mm)',
                    'type'=>'num',
                    'help'=>'Longueur totale du 3ème doigt',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomD5',
                    'label'=>'D5 (mm)',
                    'type'=>'num',
                    'help'=>'Mesure du 5ème doigt',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomCm3sup',
                    'label'=>'CM3SUP (mm)',
                    'type'=>'num',
                    'help'=>'Mesure canine - 3ème molaire (mandibule supérieure)',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomCm3inf',
                    'label'=>'CM3INF (mm)',
                    'type'=>'num',
                    'help'=>'Mesure canine - 3ème molaire (mandibule inférieure)',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomCb',
                    'label'=>'CB (mm)',
                    'type'=>'num',
                    'help'=>'Mesure condylobasale',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomLm',
                    'label'=>'LM (mm)',
                    'type'=>'num',
                    'help'=>'Mesure mandibule inférieure',
                    'options'=>array('min'=>0, 'step'=>'0.01')
                ),
                array(
                    'name'=>'biomOreille',
                    'label'=>'Oreille (mm)',
                    'type'=>'num',
                    'help'=>"Mesure de l'oreille",
                    'options'=>array('min'=>0, 'step'=>'0.01')
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
            'editUrl'=>'#/chiro/edit/biometrie/',
            'detailUrl'=>'#/chiro/biometrie/',
            'editAccess'=>3,
            'fields'=>array(
                array(
                    'name'=>'id',
                    'label'=>'ID',
                    'filter'=>array('id'=>'text'),
                    'options'=>array('visible'=>false)
                ),
                array(
                    'name'=>'ageId',
                    'label'=>'Age',
                    'filter'=>array('ageId'=>'text'),
                    'options'=>array(
                        'visible'=>true,
                        'type'=>'select',
                        'choices'=>$typesAge,
                    )
                ),
                array(
                    'name'=>'sexeId',
                    'label'=>'Sexe',
                    'filter'=>array('sexeId'=>'text'),
                    'options'=>array(
                        'visible'=>true,
                        'type'=>'select',
                        'choices'=>$typesSexe,
                    )
                    ),
                array(
                    'name'=>'biomPoids',
                    'label'=>'Poids',
                    'filter'=>array('biomPoids'=>'text'),
                    'options'=>array('visible'=>true)
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
                            'label'=>'Poids (g)',
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
                array(
                    'name'=>'Bras',
                    'fields'=>array(
                        array(
                            'name'=>'biomAb',
                            'label'=>'Avant Bras (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomD3mf1',
                            'label'=>'D3MF1 (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomD3f2f3',
                            'label'=>'D3F2F3 (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomD3total',
                            'label'=>'D3 Total (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomD5',
                            'label'=>'D5 (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                    ),
                ),
                array(
                    'name'=>'Tête',
                    'fields'=>array(
                        array(
                            'name'=>'biomCm3sup',
                            'label'=>'CM3SUP (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomCm3inf',
                            'label'=>'CM3INF (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomCb',
                            'label'=>'CB (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomLm',
                            'label'=>'LM (mm)',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'biomOreille',
                            'label'=>'Oreille (mm)',
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
