<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\ChiroBundle\Entity\ObservationTaxon;

class TaxonService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }

    public function getList($obs_id){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $data = $repo->findBy(array('obs_id'=>$obs_id));
        $out = array();
        foreach($data as $item){
            $out[] = $this->norm->normalize($item);
        }
        return $out;
    }

    public function getOne($id){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            return $this->norm->normalize($data);
        }
        return null;
    }
    
    public function create($data){
        $manager = $this->db->getManager();
        $obsTx = new ObservationTaxon();
        $this->hydrate($obsTx, $data);
        $manager->persist($obsTx);
        $manager->flush();
        return array('id'=>$obsTx->getId());
    }

    public function update($data){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return null;
        }
        $this->hydrate($obsTx, $data);
        $manager->flush();
        return array('id'=>$obsTx->getId());
    }

    public function remove($id){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return false;
        }
        $manager->remove($obsTx);
        $manager->flush();
        return true;
    }

    private function hydrate($obj, $data){
        $repo = $this->db->getRepository('PNCBaseAppBundle:Taxons');
        $tx = $repo->findOneBy(array('cd_nom'=>$data['cdNom']));
        $obj->setObsId($data['obsId']);
        $obj->setModId($data['modId']);
        $obj->setActId($data['actId']);
        $obj->setPrvId($data['prvId']);
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
            throw new \Exception($obj->errors()); 
        }
    }

}


