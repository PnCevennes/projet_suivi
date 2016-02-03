<?php

namespace PNC\HowToBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\HowToBundle\Entity\Howto;

class DefaultController extends Controller
{
    
    public function breadcrumbAction(Request $req){
        return new JsonResponse(array());
    }


    public function configAction($view_name){
        $configs = array(
            'list'=>__DIR__ . '/../Resources/clientConf/howto/list.yml',
            'detail'=>__DIR__ . '/../Resources/clientConf/howto/detail.yml',
            'form'=>__DIR__ . '/../Resources/clientConf/howto/form.yml',
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

    public function detailAction(Request $req, $id){
        // entité
        $entity = 'PNCHowToBundle:Howto';

        // schéma utilisé pour la normalisation
        // ici on utilise le fichier de mapping de l'entité puisqu'on 
        // veut en récupérer toutes les données
        $schema = '../src/PNC/HowToBundle/Resources/config/doctrine/Howto.orm.yml';
        // initialisation des services
        $es = $this->get('entityService');
        $data = $es->getOne($entity, array('id'=>$id));
        if($data){
            return new JsonResponse($es->normalize($data, $schema));
        }
        // objet inexistant
        return new JsonResponse(array(), 404);
        
    }

    function createAction(Request $request){
        $et = $this->get('entityService');
        $data = json_decode($request->getContent(), true);
        $mapping =  '../src/PNC/HowToBundle/Resources/config/doctrine/Howto.orm.yml';
        $config = array($mapping => array(
                'entity' => new Howto(),
                'data' => $data
            )
        );
        try{
            $result = $et->create($config);
            $howto = $result[$mapping];
            return new JsonResponse(array('id'=>$howto->getId()));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors());
        }
    }

    function updateAction(Request $request, $id){
        $et = $this->get('entityService');
        $data = json_decode($request->getContent(), true);
        $mapping =  '../src/PNC/HowToBundle/Resources/config/doctrine/Howto.orm.yml';
        $entity = 'PNCHowToBundle:Howto';

        $config = array($mapping => array(
                'repo' => $entity,
                'filter'=>array('id'=>$id),
                'data' => $data
            )
        );
        try{
            $result = $et->update($config);
            $howto = $result[$mapping];
            return new JsonResponse(array('id'=>$howto->getId()));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors());
        }
    }

    function deleteAction(Request $request, $id){
        $et = $this->get('entityService');
        $mapping =  '../src/PNC/HowToBundle/Resources/config/doctrine/Howto.orm.yml';
        $entity = 'PNCHowToBundle:Howto';

        $config = array($mapping => array(
                'repo' => $entity,
                'filter'=>array('id'=>$id),
            )
        );
        try{
            $result = $et->delete($config);
            $howto = $result[$mapping];
            return new JsonResponse(array('id'=>$howto->getId()));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors());
        }
    }
}
