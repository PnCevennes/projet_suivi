<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

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

        $out = array(
            'deleteAccess' => 5,
            'groups' => array(
                array(
                    'name'=>'Géographie',
                    'fields'=>array(
                        array(
                            'name'=>'geom',
                            'label'=>'Coordonnées GPS',
                            'type'=>'geom',
                            'help'=>'',
                            'options'=>array('geometryType'=>'point', 'dataUrl'=>'chiro/site'),
                            'default'=>array(),
                        ),
                    ),
                ),
                array(
                    'name'=>'Informations',
                    'fields'=>array(
                        array(
                            'name'=>'id',
                            'label'=>'id',
                            'type'=>'hidden',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'siteNom',
                            'label'=>'Nom',
                            'type'=>'string',
                            'help'=>'Nom du site',
                            'options'=>array('minLength'=>5, 'maxLength'=>250)
                        ),
                        array(
                            'name'=>'typeId',
                            'label'=>'Type',
                            'type'=>'select',
                            'help'=>'Type de lieu',
                            'options'=>array('choices'=>$typesLieu),
                            'default'=>37
                        ),
                        array(
                            'name'=>'siteCode',
                            'label'=>'Code site',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>25, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'observateurId',
                            'label'=>'Observateur',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array(
                                'url'=>'users/name/100/2', 
                                'reverseurl'=>'users/id',
                                'required'=>true,
                            ),
                        ),
                        array(
                            'name'=>'siteDate',
                            'label'=>'Date créa.',
                            'type'=>'date',
                            'help'=>"Date d'ajout du site à la base de données",
                            'options'=>array('required'=>true),
                        ),
                        array(
                            'name'=>'siteDescription',
                            'label'=>'Description',
                            'type'=>'text',
                            'help'=>'',
                            'options'=>array('maxLength'=>1000, 'minLength'=>0)
                        ),
                    ),
                ),
                array(
                    'name'=>'Etat',
                    'fields'=>array(
                        array(
                            'name'=>'siteAmenagement',
                            'label'=>'Amenagement',
                            'type'=>'file',
                            'help'=>'Amenagement du site',
                            'default'=>array(),
                            'options'=>array()
                        ),
                        array(
                            'name'=>'siteMenace',
                            'label'=>'Type menaces',
                            'type'=>'select',
                            'help'=>'Type de menace pesant sur le site',
                            'options'=>array('choices'=>$typesMenaces),
                            'default'=>64
                        ),
                        array(
                            'name'=>'siteMenaceCmt',
                            'label'=>'Menaces',
                            'type'=>'text',
                            'help'=>'Description des menaces pesant sur le site',
                            'options'=>array('maxLength'=>1000, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'siteFrequentation',
                            'label'=>'Fréquentation',
                            'type'=>'select',
                            'help'=>'Estimation de la fréquentation du lieu',
                            'options'=>array('choices'=>$typesFrequentation),
                            'default'=>59
                        ),
                    ),
                ),
                array(
                    'name'=>'Contact',
                    'fields'=>array(
                        array(
                            'name'=>'contactNom',
                            'label'=>'Nom du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>25, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactPrenom',
                            'label'=>'Prénom du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>25, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactAdresse',
                            'label'=>'Adresse du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>150, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactCodePostal',
                            'label'=>'Code postal',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>5, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactVille',
                            'label'=>'Ville',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>100, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactTelephone',
                            'label'=>'Telephone',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>15, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactPortable',
                            'label'=>'Portable',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array('maxLength'=>15, 'minLength'=>0)
                        ),
                        array(
                            'name'=>'contactCommentaire',
                            'label'=>'Commentaires contact',
                            'type'=>'text',
                            'help'=>"Insultes & commentaires désobligeants",
                            'options'=>array('maxLength'=>1000, 'minLength'=>0)
                        ),
                    ),
                ),
            ),
        );

        return new JsonResponse($out);
    }

    // path : GET chiro/config/site/list
    public function getListAction(){

        $out = array(
            'title'=>'Sites',
            'emptyMsg'=>'Aucun site pour le moment',
            'createBtnLabel'=>'Nouveau site',
            'createUrl'=>'#/chiro/edit/site/',
            'editUrl'=>'#/chiro/edit/site/',
            'detailUrl'=>'#/chiro/site/',
            'editAccess'=>5,
            'fields'=>array(
                array(
                    'name'=>'id',
                    'label'=>'ID',
                    'filter'=>array('id'=>'text'),
                    'options'=>array('visible'=>true)
                ),
                array(
                    'name'=>'siteNom',
                    'label'=>'Nom',
                    'filter'=>array('siteNom'=>'text'),
                    'options'=>array('visible'=>true)
                ),
                array(
                    'name'=>'siteCode',
                    'label'=>'Code site',
                    'filter'=>array('siteCode'=>'text'),
                    'options'=>array()
                ),
                array(
                    'name'=>'nomObservateur',
                    'label'=>'Observateur',
                    'filter'=>array('nomObservateur'=>'text'),
                    'options'=>array(),
                ),
                array(
                    'name'=>'siteDate',
                    'label'=>'Date créa.',
                    'filter'=>array('siteDate'=>'text'),
                    'options'=>array()
                ),
                array(
                    'name'=>'dernObs',
                    'label'=>'Dernière observation',
                    'filter'=>array('dernObs'=>'text'),
                    'options'=>array('visible'=>true)
                ),
                array(
                    'name'=>'typeLieu',
                    'label'=>'Type',
                    'filter'=>array('typeLieu'=>'text'),
                    'options'=>array('visible'=>true)
                ),
            ),
        );

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


        $out = array(
            'editAccess'=>3,
            'subEditAccess'=>2,
            'subSchemaUrl'=>'chiro/config/observation/list',
            'subDataUrl'=>'chiro/observation/site/',
            'groups'=>array(
                array(
                    'name'=>'Informations',
                    'fields'=>array(
                        array(
                            'name'=>'siteCode',
                            'label'=>'Code site',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'nomObservateur',
                            'label'=>'Observateur',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array(),
                        ),
                        array(
                            'name'=>'siteDate',
                            'label'=>'Date de création',
                            'type'=>'date',
                            'help'=>"Date d'ajout du site à la base de données",
                            'options'=>array(),
                        ),
                        array(
                            'name'=>'typeId',
                            'label'=>'Type',
                            'type'=>'select',
                            'help'=>'Type de lieu',
                            'options'=>array('choices'=>$typesLieu)
                        ),
                    ),
                ),
                array(
                    'name'=>'Details',
                    'fields'=>array(
                        array(
                            'name'=>'siteDescription',
                            'label'=>'Description',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'siteAmenagement',
                            'label'=>'Amenagement',
                            'type'=>'file',
                            'help'=>'Amenagement du site',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'siteFrequentation',
                            'label'=>'Fréquentation',
                            'type'=>'select',
                            'help'=>'Fréquentation du site',
                            'options'=>array('choices'=>$typesFrequentation)
                        ),
                        array(
                            'name'=>'siteMenace',
                            'label'=>'Menaces',
                            'type'=>'select',
                            'help'=>'Menaces pesant sur le site',
                            'options'=>array('choices'=>$typesMenaces)
                        ),
                        array(
                            'name'=>'siteMenaceCmt',
                            'label'=>'Description menaces',
                            'type'=>'string',
                            'help'=>'Description des menaces pesant sur le site',
                            'options'=>array()
                        ),
                    ),
                ),
                array(
                    'name'=>'Contact',
                    'fields'=>array(
                        array(
                            'name'=>'contactNom',
                            'label'=>'Nom du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactPrenom',
                            'label'=>'Prénom du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactAdresse',
                            'label'=>'Adresse du contact',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactCodePostal',
                            'label'=>'Code postal',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactVille',
                            'label'=>'Ville',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactTelephone',
                            'label'=>'Telephone',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactPortable',
                            'label'=>'Portable',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'contactCommentaire',
                            'label'=>'Commentaires contact',
                            'type'=>'string',
                            'help'=>"Insultes & commentaires désobligeants",
                            'options'=>array()
                        ),
                    ),
                ),
            ),
        );

        return new JsonResponse($out);
    }
}
