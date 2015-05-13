<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

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

        // Mode d'observation
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
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

        $out = array(
            'deleteAccess'=>5,
            'deleteAccessOverride'=>'numId', 
            'groups'=>array(
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
                            'name'=>'numId',
                            'label'=>'Numerisateur',
                            'type'=>'hidden',
                            'help'=>'',
                            'options'=>array('ref'=>'userId')
                        ),
                        array(
                            'name'=>'obsId',
                            'label'=>'Id observation',
                            'type'=>'hidden',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'cdNom',
                            'label'=>'Nom taxon',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('url'=>'chiro/taxons', 'reverseurl'=>'chiro/taxons/id', 'ref'=>'cdNom')
                        ),
                        array(
                            'name'=>'obsTxInitial',
                            'label'=>'Taxon initial',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsObjStatusValidation',
                            'label'=>'Statut validation',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typesVal, 'editLevel'=>5),
                            'default'=>56
                        ),
                        array(
                            'name'=>'modId',
                            'label'=>"Mode d'observation",
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typeMod),
                            'default'=>18
                        ),
                        array(
                            'name'=>'actId',
                            'label'=>'Activité',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typeAct),
                            'default'=>25
                        ),
                        array(
                            'name'=>'prvId',
                            'label'=>'Preuves de reproduction',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typePrv),
                            'default'=>32
                        ),
                        array(
                            'name'=>'obsValidateur',
                            'label'=>'Validateur',
                            'type'=>'hidden',
                            'help'=>'',
                            'options'=>array('ref'=>'userId', 'restrictLevel'=>5)
                        ),
                        array(
                            'name'=>'obsEspeceIncertaine',
                            'label'=>'Espece incertaine',
                            'type'=>'bool',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsCommentaire',
                            'label'=>'Commentaire',
                            'type'=>'text',
                            'help'=>"Informations complémentaires sur l'observation",
                            'options'=>array()
                        ),
                    ),
                ),
                array(
                    'name'=>'Enumeration',
                    'fields'=>array(
                        array(
                            'name'=>'obsEffectifAbs',
                            'label'=>'Effectif total',
                            'type'=>'sum',
                            'help'=>'',
                            'options'=>array(
                                'ref'=>array('obsNbMaleAdulte', 'obsNbFemelleAdulte', 'obsNbMaleJuvenile', 'obsNbFemelleJuvenile', 'obsNbMaleIndetermine', 'obsNbFemelleIndetermine', 'obsNbIndetermineIndetermine'), 
                                'modifiable'=>true
                            )
                        ),
                        array(
                            'name'=>'obsNbMaleAdulte',
                            'label'=>'Mâles adultes',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleAdulte',
                            'label'=>'Femelles adultes',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbMaleJuvenile',
                            'label'=>'Mâles juveniles',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleJuvenile',
                            'label'=>'Femelles juveniles',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbMaleIndetermine',
                            'label'=>'Mâles indeterminés',
                            'type'=>'num',
                            'help'=>'Age indéterminé',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleIndetermine',
                            'label'=>'Femelles indeterminées',
                            'type'=>'num',
                            'help'=>'Age indéterminé',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbIndetermineIndetermine',
                            'label'=>'Indetermines indeterminés',
                            'type'=>'num',
                            'help'=>'Age et sexe indéterminés',
                            'options'=>array()
                        ),
                    ),
                ),
            ),
        );

        return new JsonResponse($out);
    }
    
    // path : GET chiro/config/obstaxon/form/many
    public function getFormManyAction(){
        $norm = $this->get('normalizer');
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Thesaurus');
        $types = $repo->findBy(array('id_type'=>9));
        $typesVal = array();
        foreach($types as $tl){
            if($tl->getFkParent() != 0){
                $typesVal[] = $norm->normalize($tl, array());
            }
        }

        // Mode d'observation
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
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


        $out = array(
            'title'=>'Ajout rapide de taxons',
            'fields'=>array(
                array(
                    'name'=>'cdNom',
                    'label'=>'Nom taxon',
                    'type'=>'xhr',
                    'help'=>'',
                    'options'=>array('primary'=>true, 'url'=>'chiro/taxons', 'reverseurl'=>'chiro/taxons/id', 'ref'=>'cdNom')
                ),
                array(
                    'name'=>'obsTxInitial',
                    'label'=>'Taxon initial',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsEspeceIncertaine',
                    'label'=>'Espece incertaine',
                    'type'=>'bool',
                    'help'=>'',
                    'default'=>false,
                    'options'=>array()
                ),
                array(
                    'name'=>'modId',
                    'label'=>"Mode d'observation",
                    'type'=>'select',
                    'help'=>'',
                    'options'=>array('choices'=> $typeMod),
                    'default'=>18
                ),
                array(
                    'name'=>'actId',
                    'label'=>'Activité',
                    'type'=>'select',
                    'help'=>'',
                    'options'=>array('choices'=> $typeAct),
                    'default'=>25
                ),
                array(
                    'name'=>'prvId',
                    'label'=>'Preuves de reproduction',
                    'type'=>'select',
                    'help'=>'',
                    'options'=>array('choices'=> $typePrv),
                    'default'=>32
                ),
                array(
                    'name'=>'obsEffectifAbs',
                    'label'=>'Effectif total',
                    'type'=>'sum',
                    'help'=>'',
                    'options'=>array(
                        'min'=>0,
                        'required'=>true,
                        'ref'=>array('obsNbMaleAdulte', 'obsNbFemelleAdulte', 'obsNbMaleJuvenile', 'obsNbFemelleJuvenile', 'obsNbMaleIndetermine', 'obsNbFemelleIndetermine', 'obsNbIndetermineIndetermine'), 
                        'modifiable'=>true
                    )
                ),
                array(
                    'name'=>'obsNbMaleAdulte',
                    'label'=>'Mâles adultes',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbFemelleAdulte',
                    'label'=>'Femelles adultes',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbMaleJuvenile',
                    'label'=>'Mâles juveniles',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbFemelleJuvenile',
                    'label'=>'Femelles juveniles',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbMaleIndetermine',
                    'label'=>'Mâles indeterminés',
                    'type'=>'num',
                    'help'=>'Age indéterminé',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbFemelleIndetermine',
                    'label'=>'Femelles indeterminées',
                    'type'=>'num',
                    'help'=>'Age indéterminé',
                    'options'=>array('min'=>0)
                ),
                array(
                    'name'=>'obsNbIndetermineIndetermine',
                    'label'=>'Indetermines indeterminés',
                    'type'=>'num',
                    'help'=>'Age et sexe indéterminés',
                    'options'=>array('min'=>0)
                ),
            ),
        );
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

        // Mode d'observation
        $mods = $repo->findBy(array('id_type'=>4));
        $typeMod = array();
        foreach($mods as $tl){
            if($tl->getFkParent() != 0){
                $typeMod[] = $norm->normalize($tl, array());
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



        $out = array(
            'editAccess'=>3,
            'subEditAccess'=>3,
            'editAccessOverride'=>'numId',
            'subSchemaUrl'=>'chiro/config/biometrie/list',
            'subDataUrl'=>'chiro/biometrie/taxon/',
            'groups'=>array(
                array(
                    'name'=>'Général',
                    'fields'=>array(
                        array(
                            'name'=>'cdNom',
                            'label'=>'Cd nom',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'nomComplet',
                            'label'=>'Nom taxon',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsTxInitial',
                            'label'=>'Taxon initial',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'numId',
                            'label'=>'Numerisateur',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('url'=>'users/id')
                        ),
                        array(
                            'name'=>'obsCommentaire',
                            'label'=>'Commentaire',
                            'type'=>'string',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsValidateur',
                            'label'=>'Validateur',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('url'=>'users/id')
                        ),
                        array(
                            'name'=>'obsEspeceIncertaine',
                            'label'=>'Espece incertaine',
                            'type'=>'bool',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'modId',
                            'label'=>"Mode d'observation",
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typeMod),
                        ),
                        array(
                            'name'=>'actId',
                            'label'=>'Activité',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typeAct),
                        ),
                        array(
                            'name'=>'prvId',
                            'label'=>'Preuves de reproduction',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=> $typePrv),
                        ),
                        array(
                            'name'=>'obsEffectifAbs',
                            'label'=>'Effectif total',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                    ),
                ),
                array(
                    'name'=> 'Détail',
                    'fields'=>array(
                        array(
                            'name'=>'obsNbMaleAdulte',
                            'label'=>'Mâles adultes',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleAdulte',
                            'label'=>'Femelles adultes',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbMaleJuvenile',
                            'label'=>'Mâles juveniles',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleJuvenile',
                            'label'=>'Femelles juveniles',
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbMaleIndetermine',
                            'label'=>'Mâles indeterminés',
                            'type'=>'num',
                            'help'=>'Age indéterminé',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbFemelleIndetermine',
                            'label'=>'Femelles indeterminées',
                            'type'=>'num',
                            'help'=>'Age indéterminé',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsNbIndetermineIndetermine',
                            'label'=>'Indetermines indeterminés',
                            'type'=>'num',
                            'help'=>'Age et sexe indéterminés',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsObjStatusValidation',
                            'label'=>'Statut validation',
                            'type'=>'select',
                            'help'=>'',
                            'options'=>array('choices'=>$typesVal)
                        ),
                    ),
                ),
            ),
        );

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

        $out = array(
            'title'=>'Taxons',
            'emptyMsg'=>'Aucun taxon observé',
            'createBtnLabel'=>'Ajouter taxon',
            'createUrl'=>'#/chiro/edit/taxons/observation/',
            'fields'=>array(
                array(
                    'name'=>'nomComplet',
                    'label'=>'Nom taxon',
                    'type'=>'link',
                    'url'=>'#chiro/taxons/',
                    'ref'=>'id',
                ),
                array(
                    'name'=>'obsEffectifAbs',
                    'label'=>'Effectif total',
                    'type'=>'string',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsObjStatusValidation',
                    'label'=>'Statut validation',
                    'type'=>'select',
                    'options'=>array('choices'=>$typesVal)
                ),
            ),
        );

        return new JsonResponse($out);
    }
}


