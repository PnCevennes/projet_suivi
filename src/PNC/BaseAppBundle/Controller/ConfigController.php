<?php

namespace PNC\BaseAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

use PNC\BaseAppBundle\Entity\Fichier;

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

    // path: POST /upload_file
    public function uploadAction(Request $req){
        $fs = $this->get('fileService');
        try{
            $res = $fs->upload($req);
            return new JsonResponse($res);
        }
        catch(\Exception $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }
    /*
    public function __uploadAction(Request $req){
        $manager = $this->getDoctrine()->getManager();

        $upd = $this->get('kernel')->getContainer()->getParameter('upload_directory');
        $target_directory = $req->query->get('target', '');
        $updir = $upd . '/' . $target_directory;

        $manager->getConnection()->beginTransaction();
        foreach($req->files as $file){
            try{
                $fichier = new Fichier();
                $fichier->setPath($file->getClientOriginalName());
                $manager->persist($fichier);
                $manager->flush();

                $fileName = $fichier->getId() . '_' . $fichier->getPath();
                
                $file->move($updir, $fileName);
                $manager->getConnection()->commit();
                return new JsonResponse(array(
                    'id'=>$fichier->getId(),
                    'path'=>$fileName
                ));
            }
            catch(\Exception $e){
                $manager->getConnection()->rollback();
                return new JsonResponse(array('err'=>$e->getMessage()), 400);
            }
        }
        return new JsonResponse(array('err'=>'No files'), 400);
    }
     */

    // path: DELETE /upload_file/{file_id}
    public function deleteFileAction(Request $req, $file_id){
        $fs = $this->get('fileService');
        $res = $fs->delete_file($file_id);
        return new JsonResponse($res);
    }
    /*
    public function deleteFileAction(Request $req, $file_id){
        $upd = $this->get('kernel')->getContainer()->getParameter('upload_directory');
        $target_directory = $req->query->get('target', '');
        $updir = $upd . '/' . $target_directory;

        $id = substr($file_id, 0, strpos($file_id, '_'));
        $deleted = false;
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Fichier');
        $fich = $repo->findOneById($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($fich);
        $manager->flush();
        $target_directory = $req->request->get('target', '');
        $fdir = $updir . '/' . $file_id;
        if(file_exists($fdir)){
            unlink($fdir);
            $deleted = true;
        }
        return new JsonResponse(array(
            'id'=>$file_id, 
            'fichier'=>$fich,
            'fdir'=>$fdir,
            'deleted'=>$deleted
        ));
    }
    */

    // path: GET /commune/{insee}
    public function getCommuneAction(Request $req, $insee){
        $db = $this->getDoctrine()->getConnection();
        $req = $db->prepare('SELECT nom_reel FROM ref_geographique.l_communes WHERE insee_com=:insee');
        $req->bindParam('insee', $insee);
        $req->execute();
        $res = $req->fetchAll();
        if($res[0]){
            $result = $res[0]['nom_reel'];
            return new JsonResponse(array('id'=>$insee, 'label'=>$result));
        }
        return new JsonResponse(array('id'=>$insee), 404);
    }
}
