<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\ChiroBundle\Entity\ObservationTaxon;

class TaxonService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    // service biometrie
    private $biometrieService;

    public function __construct($db, $norm, $biomServ){
        $this->db = $db;
        $this->norm = $norm;
        $this->biometrieService = $biomServ;
    }

    public function getList($obs_id){
        $out = array();
        if($obs_id){
            $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
            $data = $repo->findBy(array('obs_id'=>$obs_id));
            foreach($data as $item){
                $out[] = $this->norm->normalize($item);
            }
        }
        else{
            $repo = $this->db->getRepository('PNCChiroBundle:ValidationTaxonView');
            $data = $repo->findAll();
            foreach($data as $item){
                $out_item = array(
                    'type'=>'Feature', 
                    'properties'=>$this->norm->normalize($item, array('obsDate', 'geom')),
                    'geometry'=>$item->getGeom()
                    );
            
                $out_item['properties']['obsDate'] = $item->getObsDate()->format('Y-m-d');
                $out[] = $out_item;
            }
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
    
    public function create($data, $db=null, $commit=true){
        if($db){
            $manager = $db;
        }
        else{
            $manager = $this->db->getManager();
        }
        if($commit){
            $manager->getConnection()->beginTransaction();
        }
        try{
            $obsTx = new ObservationTaxon();
            $this->hydrate($obsTx, $data);
            $manager->persist($obsTx);
            $manager->flush();
            if(isset($data['__biometries__'])){
                foreach($data['__biometries__'] as $biom){
                    $biom['obsTxId'] = $obsTx->getId();
                    $biom['biomCommentaire'] = '';
                    $this->biometrieService->create($biom, false);
                }
            }
        }
        catch(DataObjectException $e){
            if($commit){
                $manager->getConnection()->rollback();
                throw new DataObjectException($e->getErrors());
            }
        }
        if($commit){
            $manager->getConnection()->commit();
        }
        return array('id'=>$obsTx->getId());
    }

    public function update($id, $data){
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

    public function remove($id, $cascade=false){
        $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
        $manager = $this->db->getManager();
        $obsTx = $repo->findOneBy(array('id'=>$id));
        if(!$obsTx){
            return false;
        }
        $biometries = $this->biometrieService->getList($id);
        if($cascade){
            foreach($biometries as $biom){
                $this->biometrieService->remove($biom['id']);
            }
        }
        else{
            if($biometries){
                throw new CascadeException();
            }
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


