<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller{
    
    // path: /chiro/site
    public function listAction(){
        /*
         * retourne la liste des sites "chiro"
         */
        $base = $this->get('BaseSiteService');
        $norm = $this->get('normalizer');

        $out = $base->normalize($base->getListByApp(1));

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:InfoSite');
        $infos = $repo->findAll();
        foreach($infos as $info){
            $out[$info->getSiteId()]['infos'] = $norm->normalize($info, array('parentSite'));
        }
        
        return new JsonResponse(array('v'=>'liste sites', 'r'=>$out));
    }


    // path: /chiro/site/detail/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'un site chiro
         */
        $base = $this->get('BaseSiteService');
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:InfoSite');
        $infos = $repo->findOneById($id);
        if(!$infos){
            return new JsonResponse(array('v'=>'detail site', 'err'=>404));
        }

        $out = $base->normalize($base->getById($infos->getSiteId()));
        $out['site'] = $norm->normalize($infos, array('parentSite'));

        return new JsonResponse(array('v'=>'detail site', 'r'=>$out));
    }


    // path: /chiro/site/editer/{id}
    public function editAction($id=null){
        return new Response('formulaire site chiro');
    }


    // path: /chiro/site/enreg
    public function saveAction($id=null){
        return new Response('enregistrer site chiro');
    }


    // path; /chiro/site/suppr/{id}
    public function deleteAction($id){
        return new Response('supprimer site chiro');
    }
}
