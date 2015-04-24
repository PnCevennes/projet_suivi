<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\BaseAppBundle\Entity\Site;
use PNC\ChiroBundle\Entity\InfoSite;
use PNC\ChiroBundle\Entity\SiteFichiers;

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

        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'siteNom'=>$info->getSiteNom(),
                'siteDate'=>!is_null($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '',
                'dernObs'=>!is_null($info->getDernObs()) ? $info->getDernObs()->format('Y-m-d'): '',
                'nomObservateur'=>$info->getNomObservateur(),
                'siteCode'=>$info->getSiteCode(),
                'typeLieu'=>$info->getTypeLieu(),
            );
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
            return new JsonResponse(array('v'=>'detail site', 'err'=>404), 404);
        }

        $out_item = $norm->normalize($info, array('siteDate', 'geom', 'dernObs', 'siteAmenagement'));
        $out_item['siteAmenagement'] = $info->getSiteAmenagement();
        $out_item['siteDate'] = !is_null($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
        $out_item['dernObs'] = !is_null($info->getDernObs()) ? $info->getDernObs()->format('Y-m-d'): '';
        $out_item['geom'] = array($info->getGeom()['coordinates']);

        return new JsonResponse($out_item);
    }


    /*
     * Peuple un objet Site avec les infos passées en POST
     */
    private function hydrateSite($site, $data){
        $logger = $this->get('logger');
        $norm = $this->get('normalizer');

        $gs = $this->get('geometry');
        $geom = $gs->getPoint($data['geom']);
        $site->setSiteNom($data['siteNom']);
        $site->setTypeId($data['typeId']);
        if(strpos($data['siteDate'], '/')!==false){
            $date = \DateTime::createFromFormat('d/m/Y', $data['siteDate']);
        }
        else{
            $date = \DateTime::createFromFormat('Y-m-d', substr($data['siteDate'], 0, 10));
        }
        $site->setSiteDate($date);
        $site->setSiteDescription($data['siteDescription']);
        $site->setSiteCode($data['siteCode']);
        $site->setObservateurId($data['observateurId']);
        $site->setGeom($geom);

        $logger->info($site->getTypeId());


        if($site->errors()){
            throw new \Exception(); //TODO lever une exception explicite
        }
    }


    /*
     * Peuple un objet InfoSite avec les infos passées en POST
     */
    private function hydrateInfoSite($site, $data){
        $site->setSiteFrequentation($data['siteFrequentation']);
        $site->setSiteMenace($data['siteMenace']);
        $site->setContactNom($data['contactNom']);
        $site->setContactPrenom($data['contactPrenom']);
        $site->setContactAdresse($data['contactAdresse']);
        $site->setContactCodePostal($data['contactCodePostal']);
        $site->setContactVille($data['contactVille']);
        $site->setContactTelephone($data['contactTelephone']);
        $site->setContactPortable($data['contactPortable']);
        $site->setContactCommentaire($data['contactCommentaire']);
        if($site->errors()){
            throw new \Exception(); //TODO lever une exception explicite
        }
    }


    // path: PUT /chiro/site
    public function createAction(Request $req){
        $props = json_decode($req->getContent(), true);

        $logger = $this->get('logger');
        // manager de base de données
        $manager = $this->getDoctrine()->getManager();
        // initialisation transaction
        $manager->getConnection()->beginTransaction();

        $site = new Site();
        $infoSite = new InfoSite();
        try{
            $this->hydrateSite($site, $props);
            $this->hydrateInfoSite($infoSite, $props);

            // enregistrement pnc.base_site
            $manager->persist($site);
            $manager->flush();
            
            // enregistrement chiro.chiro_infos_site
            $infoSite->setParentSite($site);
            $manager->persist($infoSite);
            $manager->flush();

            // validation transaction
            $manager->getConnection()->commit();
        }
        catch(\Exception $e){
            $manager->getConnection()->rollback();
            $logger->info($e);
            $errs = array_merge($site->errors(), $infoSite->errors());
            return new JsonResponse($errs, 400);
        }

        try{
            // enregistrement des fichiers liés
            foreach($props['siteAmenagement'] as $fich_id){
                if(!strpos($fich_id, '_')){
                    $fichier = new SiteFichiers();
                    $fichier->setSiteId($site->getId());
                    $fichier->setFichierId($fich_id);
                    $manager->persist($fichier);
                    $manager->flush();
                }
            }
        }
        catch(\Exception $e){
            print_r($e->getMessage());
        }


        return new JsonResponse(array('id'=>$site->getId()));
    }


    // path: POST /chiro/site/{id}
    public function updateAction(Request $req, $id=null){
        $props = json_decode($req->getContent(), true);
        $logger = $this->get('logger');
        $logger->info(json_encode($props));

        $norm = $this->get('normalizer');
        // entity manager sites
        $em = $this->getDoctrine()->getRepository('PNCChiroBundle:InfoSite');
        $infoSite = $em->findOneBy(array('site_id'=>$id));
        $site = $infoSite->getParentSite();

        // manager de base de données
        $manager = $this->getDoctrine()->getManager();
        // initialisation transaction
        $manager->getConnection()->beginTransaction();

        try{
            $this->hydrateSite($site, $props);
            $this->hydrateInfoSite($infoSite, $props);

            // enregistrement pnc.base_site
            $manager->flush();


            // enregistrement chiro.chiro_infos_site
            $infoSite->setParentSite($site);
            $manager->flush();

            // validation transaction
            $manager->getConnection()->commit();
        }
        catch(\Exception $e){
            $logger->info($e);
            $manager->getConnection()->rollback();
            $errs = array_merge($site->errors(), $infoSite->errors());

            return new JsonResponse($errs, 400);
        }
        try{
            // enregistrement des fichiers liés
            foreach($props['siteAmenagement'] as $fich_id){
                if(!strpos($fich_id, '_')){
                    $fichier = new SiteFichiers();
                    $fichier->setSiteId($site->getId());
                    $fichier->setFichierId($fich_id);
                    $manager->persist($fichier);
                    $manager->flush();
                }
            }
        }
        catch(\Exception $e){
            print_r($e);
        }

        return new JsonResponse(array('id'=>$site->getId()));
    }


    // path; DELETE /chiro/site/{id}
    public function deleteAction($id){
        $em = $this->getDoctrine()->getRepository('PNCChiroBundle:InfoSite');
        $infoSite = $em->findOneBy(array('site_id'=>$id));
        $site = $infoSite->getParentSite();

        $manager = $this->getDoctrine()->getManager();

        // suppression des éléments
        $manager->remove($site);
        $manager->remove($infoSite);
        $manager->flush();

        return new JsonResponse(array('vue'=>'delete', 'id'=>$id));
    }
}
