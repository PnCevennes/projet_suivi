<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\BaseAppBundle\Entity\Site;
use PNC\ChiroBundle\Entity\InfoSite;

class SiteController extends Controller{
    
    // path: GET /chiro/site
    public function listAction(){
        /*
         * retourne la liste des sites "chiro"
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:SiteView');
        $infos = $repo->findAll();
        $out = array();

        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = $norm->normalize($info, array('siteDate', 'geom', 'dernObs'));
            $out_item['properties']['siteDate'] = !empty($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
            $out_item['properties']['dernObservation'] = !empty($info->getDernObs()) ? $info->getDerObs()->format('Y-m-d'): '';
            $out_item['geometry'] = $info->getGeom();
            $out[] = $out_item;
        }

        return new JsonResponse($out);
    }


    // path: GET /chiro/site/{id}
    public function detailAction($id){
        /*
         * retourne le détail d'un site chiro
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:SiteView');
        $info = $repo->findOneById($id);
        if(!$info){
            return new JsonResponse(array('v'=>'detail site', 'err'=>404));
        }

        $out_item = array('type'=>'Feature');
        $out_item['properties'] = $norm->normalize($info, array('siteDate', 'geom', 'dernObs'));
            $out_item['properties']['siteDate'] = !empty($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
            $out_item['properties']['dernObservation'] = !empty($info->getDernObs()) ? $info->getDerObs()->format('Y-m-d'): '';
        $out_item['geometry'] = $info->getGeom();

        return new JsonResponse($out_item);
    }


    /*
     * Peuple un objet Site avec les infos passées en POST
     */
    private function hydrateSite($site, $data, $geometry){
        $gs = $this->get('geometry');
        $geom = $gs->pointJsonToWKT($geometry);
        $site->setSiteNom($data['siteNom']);
        $site->setTypeId($data['typeLieu']);
        $site->setSiteDate($data['siteDate']);
        $site->setSiteDescription($data['siteDescription']);
        $site->setSiteCode($data['siteCode']);
        $site->setObservateurId($data['observateurId']);
        $site->setGeom($geom);
        if($site->errors()){
            throw new Exception();
        }
    }


    /*
     * Peuple un objet InfoSite avec les infos passées en POST
     */
    private function hydrateInfoSite($site, $data){
        $site->setSiteAmenagement($data['siteAmenagement']);
        $site->setSiteMenace($data['siteMenace']);
        $site->setContactNom($data['contactNom']);
        $site->setContactPrenom($data['contactPrenom']);
        $site->setContactAdresse($data['contactAdresse']);
        $site->setContactCodePostal($data['contactCodePostal');
        $site->setContactVille($data['contactVille']);
        $site->setContactTelephone($data['contactTelephone']);
        $site->setContactPortable($data['contactPortable']);
        $site->setContactCommentaire($data['contactCommentaire']);
        if($site->errors()){
            throw new Exception();
        }
    }


    // path: PUT /chiro/site
    public function createAction(Request $req){
        $res = json_decode($req->getContent());
        $props = $res['properties'];

        $site = new Site();
        $infoSite = new InfoSite();
        try{
            $this->populateSite($site, $props, $res['geometry']);
            $this->populateInfoSite($infoSite, $props);
        }
        catch(Exception $e){
            $errs = $site->errors() + $infoSite->errors();

            return new JsonResponse($errs, 422);
        }


        return new JsonResponse(array('vue'=>'create', 'data'=>$res));
    }


    // path: POST /chiro/site/{id}
    public function updateAction(Request $req, $id=null){
        $res = json_decode($req->getContent());
        return new JsonResponse(array('vue'=>'update', 'data'=>$res));
    }


    // path; DELETE /chiro/site/{id}
    public function deleteAction($id){
        return new Response('supprimer site chiro');
    }
}
