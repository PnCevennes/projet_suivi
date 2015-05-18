<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use PNC\ChiroBundle\Entity\Biometrie;

class BiometrieService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }

    /*
     * Retourne la liste des biométries liées à une observation de taxon
     * params:
     *      otx_id=>id de l'observation de taxon
     */
    public function getList($otx_id){
        $repo = $this->db->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findBy(array('obs_tx_id'=>$otx_id));

        $out = array();
        foreach($data as $item){
            $out[] = $this->norm->normalize($item);
        }
        return $out;
    }

    /*
     *  Retourne la biométrie identifiée par l'id fourni
     *  params: 
     *      id: l'id de la biometrie
     */
    public function getOne($id){
        $repo = $this->db->getRepository('PNCChiroBundle:Biometrie');
        $data = $repo->findOneBy(array('id'=>$id));
        if($data){
            return $this->norm->normalize($data);
        }
        return null;
    }

    /*
     *  Crée une nouvelle biométrie avec les données fournies et retourne son ID
     *  params:
     *      data: dictionnaire de données
     *  return:
     *      {id: id de la biom créée}
     *  raise:
     *      DataObjectException si les données sont invalides
     */
    public function create($data, $commit=true){
        $manager = $this->db->getManager();
        if($commit){
            $manager->getConnection()->beginTransaction();
        }
        try{
            $biom = new Biometrie();
            $this->hydrate($biom, $data);
            $manager->persist($biom);
            $manager->flush();
        }
        catch(DataObjectException $e){
            if($commit){
                $manager->getConnection()->rollback();
            }
            throw new DataObjectException($e->getErrors());
        }
        if($commit){
            $manager->getConnection()->commit();
        }
        return array('id'=>$biom->getId());

    }

    /*
     *  Met à jour une biométrie avec les données fournies et retourne son ID
     *  params:
     *      id: l'ID de la biométrie à modifier
     *      data: dictionnaire de données
     *  return:
     *      {id: id de la biom modifiée}
     *  raise:
     *      DataObjectException si les données sont invalides
     */
    public function update($id, $data){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNCChiroBundle:Biometrie');
        $biom = $repo->findOneBy(array('id'=>$id));
        if(!$biom){
            return null;
        }
        $this->hydrate($biom, $data);
        $manager->flush();
        return array('id'=>$biom->getId());
    }

    /*
     *  Supprime une biométrie
     *  params:
     *      id: l'ID de la biométrie à supprimer
     *  return:
     *      bool succès
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNCChiroBundle:Biometrie');
        $biom = $repo->findOneBy(array('id'=>$id));
        if($biom){
            $manager->remove($biom);
            $manager->flush();
            return true;
        }
        return false;
    }

    /*
     *  Factorisation de l'affectation des champs aux objets Biométrie
     *  Aucune valeur de retour, la méthode agit sur la référence à l'objet
     *  params:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  raise:
     *      DataObjectException en cas de données invalides
     */
    private function hydrate($obj, $data){
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
            throw new DataObjectException($obj->errors());
        }
    }
}



