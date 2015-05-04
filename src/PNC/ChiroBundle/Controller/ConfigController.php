<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller{

    // path: GET chiro/taxons/{q}
    public function getTaxonsAction($q){
        $out = array();
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Taxons');
        $resp = $repo->getLike($q);
        foreach($resp as $item){
            $out[] = array(
                'label'=>$item->getNomComplet(),
                'id'=>$item->getCdNom());
        }
        return new JsonResponse($out);
    }

    // path: GET chiro/taxons/{q}
    public function getTaxonsIdAction($q){
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Taxons');
        $out = $repo->findOneBy(array('cd_nom'=>$q));
        return new JsonResponse(array('id'=>$q, 'label'=>$out->getNomComplet()));
    }

    public function getSiteConfigAction(){

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


        /*
         * description du formulaire
         */
        $out = array(
            'formSite'=>array(
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
                        'url'=>'/chiro/observateurs', 
                        'reverseurl'=>'/chiro/observateurs/id'
                    ),
                ),
                array(
                    'name'=>'siteDate',
                    'label'=>'Date créa.',
                    'type'=>'date',
                    'help'=>"Date d'ajout du site à la base de données",
                    'options'=>array(),
                ),
                array(
                    'name'=>'siteDescription',
                    'label'=>'Description',
                    'type'=>'text',
                    'help'=>'',
                    'options'=>array('maxLength'=>1000, 'minLength'=>0)
                ),
                array(
                    'name'=>'siteAmenagement',
                    'label'=>'Amenagement',
                    'type'=>'file',
                    'help'=>'Amenagement du site',
                    'default'=>array(),
                    'options'=>array()
                ),
                array(
                    'name'=>'siteFrequentation',
                    'label'=>'Fréquentation',
                    'type'=>'text',
                    'help'=>'Fréquentation du site',
                    'options'=>array('maxLength'=>1000, 'minLength'=>0)
                ),
                array(
                    'name'=>'siteMenace',
                    'label'=>'Menaces',
                    'type'=>'text',
                    'help'=>'Menaces pesant sur le site',
                    'options'=>array('maxLength'=>1000, 'minLength'=>0)
                ),
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
            'listSite'=>array(
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
                    'options'=>array()
                ),
                array(
                    'name'=>'typeLieu',
                    'label'=>'Type',
                    'filter'=>array('typeLieu'=>'text'),
                    'options'=>array('visible'=>true)
                ),
            ),
            'detailSite'=>array(
                '__groups__'=>array('Informations', 'Details', 'Contact'),
                'Informations'=>array(
                    array(
                        'name'=>'siteNom',
                        'label'=>'Nom',
                        'type'=>'hidden',
                        'help'=>'Nom du site',
                        'options'=>array()
                    ),
                    array(
                        'name'=>'id',
                        'label'=>'id',
                        'type'=>'hidden',
                        'help'=>'',
                        'options'=>array('hidden'=>true)
                    ),
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
                        'type'=>'string',
                        'help'=>'Type de lieu',
                        'options'=>array()
                    )
                ),
                "Details"=>array(
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
                        'type'=>'string',
                        'help'=>'Fréquentation du site',
                        'options'=>array()
                    ),
                    array(
                        'name'=>'siteMenace',
                        'label'=>'Menaces',
                        'type'=>'string',
                        'help'=>'Menaces pesant sur le site',
                        'options'=>array()
                    ),
                ),
                "Contact"=>array(
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
        );
        return new JsonResponse($out);
    }

    public function getObservationConfigAction(){

        $out = array(
            'detailObs'=>array(
                array(
                    'name'=>'siteNom',
                    'label'=>'Site',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsDate',
                    'label'=>'Date',
                    'type'=>'date',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'numerisateur',
                    'label'=>'Numerisateur',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'observateurs',
                    'label'=>'Observateurs',
                    'type'=>'multi',
                    'help'=>'',
                    'options'=>array('nomComplet')
                ),
                array(
                    'name'=>'obsCommentaire',
                    'label'=>'Commentaires',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsTemperature',
                    'label'=>'Température',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsHumidite',
                    'label'=>'Humidité',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
            ),
            'listObs'=>array(

            ),
            'formObs'=>array(
                array(
                    'name'=>'id',
                    'label'=>'Id',
                    'type'=>'hidden',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'siteId',
                    'label'=>'Site',
                    'type'=>'hidden',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'observateurs',
                    'label'=>'Observateurs',
                    'type'=>'xhr',
                    'help'=>'',
                    'options'=>array('multi'=>true, 'url'=>'/chiro/observateurs', 'reverseurl'=>'/chiro/observateurs/id', 'ref'=>'nomComplet')
                ),
                array(
                    'name'=>'obsDate',
                    'label'=>'Date',
                    'type'=>'date',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsCommentaire',
                    'label'=>'Commentaires',
                    'type'=>'text',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsTemperature',
                    'label'=>'Température',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsHumidite',
                    'label'=>'Humidité',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),

            ),
        );

        return new JsonResponse($out);
    }
    
    // path: GET /chiro/obsTxConfig
    public function getObservationTaxonConfigAction(){
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
            'detailObsTx'=>array(
                '__groups__'=>array('Général', 'Détail'),
                'Général'=>array(
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
                        'options'=>array('url'=>'chiro/observateurs/id')
                    ),
                    array(
                        'name'=>'obsEspeceIncertaine',
                        'label'=>'Espece incertaine',
                        'type'=>'bool',
                        'help'=>'',
                        'options'=>array()
                    ),
                    array(
                        'name'=>'obsEffectifAbs',
                        'label'=>'Effectif total',
                        'type'=>'num',
                        'help'=>'',
                        'options'=>array()
                    ),
                ),
                'Détail'=>array(
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
                        'type'=>'num',
                        'help'=>'',
                        'options'=>array()
                    ),
                ),
            ),
            'listObsTx'=>array(
                array(
                    'name'=>'nomComplet',
                    'label'=>'Nom taxon',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsEffectifAbs',
                    'label'=>'Effectif total',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array()
                ),
                array(
                    'name'=>'obsObjStatusValidation',
                    'label'=>'Statut validation',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array()
                ),
            ),
        );
        return new JsonResponse($out);
    }

    public function getBiometrieConfigAction(){
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
            'listBiom'=>array(
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
            ),
            'detailBiom'=>array(
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
            )
        );

        return new JsonResponse($out);
    }
}



