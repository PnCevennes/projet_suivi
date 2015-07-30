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
        $data = $this->entityService->getOne(
            'PNCChiroBundle:Biometrie',
            array('id'=>$id)
        );

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
    public function create($data, $db=null){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/Biometrie.orm.yml';
        $result = $this->entityService->create(
            array(
                $schema=>array(
                    'entity'=>new Biometrie(), 
                    'data'=>$data
                )
            ),
            $db
        );
        if($result){
            $biom = $result[$schema];
            return array('id'=>$biom->getId());
        }
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
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/Biometrie.orm.yml';

        $result = $this->entityService->update(
            array(
                $schema=>array(
                    'repo'=>'PNCChiroBundle:Biometrie',
                    'filter'=>array('id'=>$id),
                    'data'=>$data
                )
            )
        );
        if($result){
            $biom = $result[$schema];
            return array('id'=>$biom->getId());
        }
    }

    /*
     *  Supprime une biométrie
     *  params:
     *      id: l'ID de la biométrie à supprimer
     *  return:
     *      bool succès
     */
    public function remove($id){
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/Biometrie.orm.yml';

        try{
            $result = $this->entityService->delete(
                array(
                    $schema=>array(
                        'repo'=>'PNCChiroBundle:Biometrie',
                        'filter'=>array('id'=>$id)
                    )
                )
            );
            return true;
        }
        catch(DataObjectException $e){
            return false;
        }
    }
}



