<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

use PNC\BaseAppBundle\Entity\Fichiers;

class ConfigController extends Controller{
    

    public function indexAction(){
        return new BinaryFileResponse('suivi.html');
    }

    // path: GET /config/apps
    public function getAppsAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/application.yml');
        $out = Yaml::parse($file);
        return new JsonResponse($out);

    }

    /*
    // path: GET /observateurs
    public function getObservateursAction($q){
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observateurs');
        $resp = $repo->getLike($q);
        $out = array();
        foreach($resp as $item){
            $out[] = array(
                'label'=>$item->getNomRole() . ' ' . $item->getPrenomRole(), 
                'id'=>$item->getIdRole());
        }
        
        return new JsonResponse($out);
    }
    */

    public function uploadAction(Request $req){
        $manager = $this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        foreach($req->files as $file){
            try{
                $fichier = new Fichiers();
                $fichier->setPath($file->getClientOriginalName());
                $manager->persist($fichier);
                $manager->flush();
                
                $file->move($this->get('kernel')->getRootDir().'/../web/uploads', $fichier->getId() . '_' . $fichier->getPath());
                $manager->getConnection()->commit();
                return new JsonResponse(array('id'=>$fichier->getId()));
            }
            catch(\Exception $e){
                $manager->getConnection()->rollback();
                return new JsonResponse(array('err'=>$e->getMessage()), 422);
            }
          return new JsonResponse(array('err'=>'No files'));
        }
    }
}
