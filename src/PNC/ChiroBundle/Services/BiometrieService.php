<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;
use PNC\ChiroBundle\Entity\Biometrie;

class BiometrieService{
    // doctrine
    private $db;

    // hydrate
    private $entityService;

    // schema
    private $schema;

    public function __construct($db, $es, $pg){
        $this->db = $db;
        $this->entityService = $es;
        $this->pagination = $pg;
        $this->schema = array(
            'id'=>null,
            'obsTxId'=>null,
            'ageId'=>null,
            'sexeId'=>null,
            'biomAb'=>null,
            'biomPoids'=>null,
            'biomD3mf1'=>null,
            'biomD3f2f3'=>null,
            'biomD3total'=>null,
            'biomD5'=>null,
            'biomCm3sup'=>null,
            'biomCm3inf'=>null,
            'biomCb'=>null,
            'biomLm'=>null,
            'biomOreille'=>null,
            'biomCommentaire'=>null,
            'numerisateurId'=>null,
        );

        $this->normalize_schema = array(
            'id'=>null,
            'obsTxId'=>null,
            'ageId'=>null,
            'sexeId'=>null,
            'biomAb'=>null,
            'biomPoids'=>null,
            'biomD3mf1'=>null,
            'biomD3f2f3'=>null,
            'biomD3total'=>null,
            'biomD5'=>null,
            'biomCm3sup'=>null,
            'biomCm3inf'=>null,
            'biomCb'=>null,
            'biomLm'=>null,
            'biomOreille'=>null,
            'biomCommentaire'=>null,
            'created'=>'date',
            'updated'=>'date',
            'numerisateurId'=>null,
        );
    }

    /*
     * Retourne la liste des biométries liées à une observation de taxon
     * params:
     *      otx_id=>id de l'observation de taxon
     */
    public function getList($request, $otx_id){
        $entity = 'PNCChiroBundle:Biometrie';
        //$data = $repo->findBy(array('obs_tx_id'=>$otx_id));
        $cpl = array(
            array(
                'name'=>'obs_tx_id',
                'compare'=>'=',
                'value'=>$otx_id
            )
        );
        $res = $this->pagination->filter_request($entity, $request, $cpl);

        $data = $res['filtered'];

        $out = array();
        foreach($data as $item){
            $out[] = $this->entityService->normalize($item, $this->normalize_schema);
        }

        return array('total'=>$res['total'], 'filteredCount'=>$res['filteredCount'], 'filtered'=>$out);
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
            return $this->entityService->normalize($data, $this->normalize_schema);
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
    public function create($data, $db=null, $commit=true){
        if(!$db){
            $manager = $this->db->getManager();
        }
        else{
            $manager = $db;
        }
        if($commit){
            $manager->getConnection()->beginTransaction();
        }
        try{
            $biom = new Biometrie();
            $this->entityService->hydrate($biom, $this->schema, $data);
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
        $this->entityService->hydrate($biom, $this->schema, $data);
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
}



