<?php

namespace PNC\HowToBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function breadcrumbAction(Request $req){
        return new JsonResponse(array());
    }


    public function configAction($view_name){
        $configs = array(
            'list'=>__DIR__ . '/../Resources/clientConf/howto/list.yml',
        );

        // initialisation configservice
        $cs = $this->get('configService');
        
        if(isset($configs[$view_name])){
            return new JsonResponse($cs->get_config($configs[$view_name]));
        }
        else{
            return new JsonResponse(array('view'=>$view_name), 404);
        }
    }


    public function listAction(Request $req){
        // entité a charger
        $entity = 'PNCHowToBundle:Howto';

        // schéma utilisé pour la normalisation
        $schema = array(
            'id'=>null,
            'htNom'=>null,
            'htValeur'=>null
        );

        // initialisation des services
        $ps = $this->get('pagination');
        $es = $this->get('entityService');

        // requête
        $result = $ps->filter_request($entity, $req);

        // mise en forme du résultat
        $out = array();
        foreach($result['filtered'] as $item){
            $out[] = $es->normalize($item, $schema);
        }
        $result['filtered'] = $out;
        return new JsonResponse($result);
    }
}
