<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\ChiroBundle\Entity\Biometrie;

class BiometrieController extends Controller
{
    // path: GET chiro/biometrie/taxon/{otx_id}
    public function listAction($otx_id=null){
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findBy(array('obs_tx_id'=>$otx_id));

        $out = array();
        foreach($data as $item){
            $out[] = $norm->normalize($item);
        }
        return new JsonResponse($out);
    }

    // path: GET chiro/biometrie/{id}
    public function detailAction($id){
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            $out = $norm->normalize($data);
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>$id), 404);
    }


    private function hydrateBiometrie($obj, $data){
        $obj->setObsTxId($data['obsTxId']);
        $obj->setAgeId($data['ageId']);
        $obj->setSexeId($data['sexeId']);
        $obj->setBiomAb($data['biomAb']);
        $obj->setBiomPoids($data['biomPoids']);
        $obj->setBiomD3mf1($data['biomD3mf1']);
        $obj->setBiomD3f2f3($data['biomD3f2f3']);
        $obj->setBiomD3total($data['biomD3total']);
        $obj->setBiomD5($data['biomD5']);
        $obj->setBiomCm3sup($data['biomCm3sup']);
        $obj->setBiomCm3inf($data['biomCm3inf']);
        $obj->setBiomCb($data['biomCb']);
        $obj->setBiomLm($data['biomLm']);
        $obj->setBiomOreille($data['biomOreille']);
        $obj->setBiomCommentaire($data['biomCommentaire']);
        if($obj->errors()){
            throw new \Exception() //TODO utiliser une exception plus précise
        }
    }

    // path: PUT chiro/biometrie
    public function createAction($id=null){
        $manager = $this->getDoctrine()->getManager();
        $biom = new Biometrie();
        try{
            $this->hydrateBiometrie($biom);
            $manager->persist($biom);
            $manager->flush();
            return new JsonResponse(array('id'=>$biom->getId()));
        }
        catch(\Exception $e){
            $errs = $obj->errors();
            return new JsonResponse($errs, 400);
        }
    }

    // path: POST chiro/biometrie/{id}
    public function updateAction($id=null){
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $biom = $repo->getOneBy(array('id'=>$id));

        return new Response('enregistrer biometrie');
        try{
            $this->hydrateBiometrie($biom);
            $manager->flush();
            return new JsonResponse(array('id'=>$biom->getId()));
        }
        catch(\Exception $e){
            $errs = $obj->errors();
            return new JsonResponse($errs, 400);
        }
    }

    // path: DELETE chiro/biometrie/{id}
    public function deleteAction($id){
        $manager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:Biometrie');
        $biom = $repo->getOneBy(array('id'=>$id));
        if($biom){
            $manager->remove($biom);
            $manager->flush();
            return new JsonResponse(array('id'=>$id));
        }
        else{
            return new JsonResponse(array('id'=>$id), 400);
        }   
    }
}


