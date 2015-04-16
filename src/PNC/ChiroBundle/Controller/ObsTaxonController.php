<?php

namespace PNC\ChiroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PNC\ChiroBundle\Entity\ObservationTaxon;

class ObsTaxonController extends Controller
{
    // path: GET chiro/obs_taxon/observation/{obs_id}
    public function listAction($obs_id=null){
        /*
         * retourne la liste des observations taxon associées à une obs
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationTaxon');
        $data = $repo->findBy(array('obs_id'=>$obs_id));
        $out = array();
        foreach($data as $item){
            $out[] = $norm->normalize($item);
        }
        return new JsonResponse($out);
    }

    // path: GET chiro/obs_taxon/{id}
    public function detailAction($id){
        /*
         * retourne une observation taxon identifiée par ID
         */
        $norm = $this->get('normalizer');

        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationTaxon');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            $out = $norm->normalize($data);
            return new JsonResponse($out);
        }
        return new JsonResponse(array('id'=>$id), 404);
    }


    private function hydrateObsTaxon($obj, $data){
        $repo = $this->getDoctrine()->getRepository('PNCBaseAppBundle:Taxons');
        $tx = $repo->findOneBy(array('cd_nom'=>$data['cdNom']));
        $obj->setObsId($data['obsId']);
        $obj->setObsTxInitial($data['obsTxInitial']);
        $obj->setObsEspeceIncertaine($data['obsEspeceIncertaine']);
        $obj->setObsEffectifAbs($data['obsEffectifAbs']);
        $obj->setObsNbMaleAdulte($data['obsNbMaleAdulte']);
        $obj->setObsNbFemelleAdulte($data['obsNbFemelleAdulte']);
        $obj->setObsNbMaleJuvenile($data['obsNbMaleJuvenile']);
        $obj->setObsNbFemelleJuvenile($data['obsNbFemelleJuvenile']);
        $obj->setObsNbMaleIndetermine($data['obsNbMaleIndetermine']);
        $obj->setObsNbFemelleIndetermine($data['obsNbFemelleIndetermine']);
        $obj->setObsNbIndetermineIndetermine($data['obsNbIndetermineIndetermine']);
        $obj->setObsObjStatusValidation($data['obsObjStatusValidation']);
        $obj->setObsCommentaire($data['obsCommentaire']);
        $obj->setCdNom($data['cdNom']);
        $obj->setNomComplet($tx->getNomComplet());
        $obj->setObsValidateur($data['obsValidateur']);
        if($obj->errors()){
            throw new \Exception(); //TODO lever exception explicite
        }
    }

    // path: PUT chiro/obs_taxon
    public function createAction(Request $req){
        $data = json_decode($req->getContent(), true);

        $manager = $this->getDoctrine()->getManager();
        $obsTx = new ObservationTaxon();
        try{
            $this->hydrateObsTaxon($obsTx, $data);
            $manager->persist($obsTx);
            $manager->flush();
            return new JsonResponse(array('id'=>$obsTx->getId()));
        }
        catch(\Exception $e){
            $errs = $obsTx->errors();
            return new JsonResponse($errs, 400);
        }
    }

    // path: POST chiro/obs_taxon/{id}
    public function updateAction(Request $req, $id=null){
        $data = json_decode($req->getContent(), true);
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationTaxon');

        $manager = $this->getDoctrine()->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return new JsonResponse(array('id'=>$id), 404);
        }
        try{
            $this->hydrateObsTaxon($obsTx, $data);
            $manager->flush();
            return new JsonResponse(array('id'=>$obsTx->getId()));
        }
        catch(\Exception $e){
            $errs = $obsTx->errors();
            return new JsonResponse($errs, 400);
        }
    }

    // path: DELETE chiro/obs_taxon/{id}
    public function deleteAction($id){
        $repo = $this->getDoctrine()->getRepository('PNCChiroBundle:ObservationTaxon');
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return new JsonResponse(array('id'=>$id), 404);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($obsTx);
        $manager->flush();

        return new JsonResponse(array('id'=>$id));
    }
}


