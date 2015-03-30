<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\BaseAppBundle\Entity\Fichiers;

class ConfigController extends Controller{
    

    public function indexAction(){
        return new BinaryFileResponse('suivi.html');
    }

    // path: GET /apps
    public function getAppsAction(){
        return new JsonResponse(array(
            array('id'=>'1', 'name'=>'chiro'),
            //array('id'=>'2', 'name'=>'cheveche'),
        ));
    }

    // path: POST /observateurs
    public function getObservateursAction(Request $req){
        $input = json_decode($req->getContent(), true);
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Observateurs');
        if(isset($input['id'])){
            $resp = $repo->findOneBy(array('id_role'=>$input['id']));
                $out = array(
                    'label'=>$resp->getNomRole() . ' ' . $resp->getPrenomRole(), 
                    'id'=>$resp->getIdRole());
            return new JsonResponse($out);
        }
        else{
            $resp = $repo->getLike($input['label']);
            $out = array();
            foreach($resp as $item){
                $out[] = array(
                    'label'=>$item->getNomRole() . ' ' . $item->getPrenomRole(), 
                    'id'=>$item->getIdRole());
            }
        }
        return new JsonResponse($out);
    }

    public function uploadAction(Request $req){
        $manager = $this->getDoctrine()->getManager();
        $manager->getConnection()->beginTransaction();
        print_r($req->files);
        foreach($req->files as $file){
            try{
                $fichier = new Fichiers();
                $fichier->setPath($file->getClientOriginalName());
                $manager->persist($fichier);
                $manager->flush();

                $file->move('uploads', $fichier->getId() . '_' . $fichier->getPath());
                $manager->getConnection()->commit();
            }
            catch(\Exception $e){
                $manager->getConnection()->rollback();
                return new JsonResponse(array('err'=>$e->getMessage()), 422);
            }
            return new JsonResponse(array('id'=>$fichier->getId()));
        }
    }
}
