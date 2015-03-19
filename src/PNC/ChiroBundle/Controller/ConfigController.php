<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller{
    public function getConfAction(){
        //TODO
        $typesLieu = array(
            array(
                'id'=>1,
                'label'=>'foo'), 
            array(
                'id'=>2,
                'label'=>'bar'),
            array(
                'id'=>3,
                'label'=>'baz'));

        $out = array(
            'formSite'=>array(
                array(
                    'name'=>'id',
                    'label'=>'id',
                    'type'=>'num',
                    'help'=>'',
                    'options'=>array('hidden'=>true)
                ),
                array(
                    'name'=>'siteNom',
                    'label'=>'Nom',
                    'type'=>'string',
                    'help'=>'Nom du site',
                    'options'=>array('minLength'=>5, 'maxLength'=>250)
                ),
                array(
                    'name'=>'siteCode',
                    'label'=>'Code site',
                    'type'=>'string',
                    'help'=>'',
                    'options'=>array('maxLength'=>25, 'minLength'=>0)
                ),
                array(
                    'name'=>'siteDate',
                    'label'=>'Date créa.',
                    'type'=>'date',
                    'help'=>"Date d'ajout du site à la base de données",
                    'options'=>array()
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
                    'type'=>'text',
                    'help'=>'Amenagement du site',
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
                    'name'=>'typeLieu',
                    'label'=>'Type',
                    'type'=>'select',
                    'help'=>'Type de lieu',
                    'options'=>array('choices'=>$typesLieu)
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
                    'label'=>'Commentaires',
                    'type'=>'text',
                    'help'=>"Tous les commentaires désobligeants à propos du contact",
                    'options'=>array('maxLength'=>1000, 'minLength'=>0)
                ),
            ),
        );
        return new JsonResponse($out);
    }
}
