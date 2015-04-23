<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class ObservationConfigController extends Controller{
    // path : GET chiro/config/observation/form
    public function getFormAction(){

        $out = array(
            'groups'=>array(
                array(
                    'name'=>'Observation',
                    'fields'=>array(
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
                            'options'=>array('multi'=>true, 'url'=>'chiro/observateurs', 'reverseurl'=>'chiro/observateurs/id', 'ref'=>'nomComplet'),
                            'default'=>array()
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
                            'type'=>'num',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'obsHumidite',
                            'label'=>'Humidité',
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

    // path : GET chiro/config/observation/list
    public function getListAction(){
        $out = array(
            'title'=>'Observations',
            'emptyMsg'=>'Aucune observation pour le moment',
            'createBtnLabel'=>'Nouvelle obs.',
            'createUrl'=>'#/chiro/edit/observation/site/',
            'fields'=>array(
                array(
                    'name'=>'id',
                    'type'=>'hidden',
                ),
                array(
                    'name'=>'obsDate',
                    'label'=>"Date d'observation",
                    'type'=>'link',
                    'url'=>'#/chiro/observation/',
                    'ref'=>'id',
                ),
                array(
                    'name'=>'observateurs',
                    'label'=>'Observateurs',
                    'type'=>'list',
                ),
                array(
                    'name'=>'nbTaxons',
                    'label'=>'Taxons',
                    'type'=>'string',
                ),
            ),
        );

        return new JsonResponse($out);
    }

    // path : GET chiro/config/observation/detail
    public function getDetailAction(){

        $out = array(
            'subSchemaUrl'=>'chiro/config/obstaxon/list',
            'subDataUrl'=>'chiro/obs_taxon/observation/',
            'groups'=>array(
                array(
                    'name'=>'Observation',
                    'fields'=>array(
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
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('url'=>'chiro/observateurs/id')
                        ),
                        array(
                            'name'=>'observateurs',
                            'label'=>'Observateurs',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('multi'=>true, 'url'=>'chiro/observateurs/id')
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
                ),
            ),
        );

        return new JsonResponse($out);
    }
}
