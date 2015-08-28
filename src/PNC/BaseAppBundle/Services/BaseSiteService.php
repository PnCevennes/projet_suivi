<?php

namespace PNC\BaseAppBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\BaseAppBundle\Entity\Site;


class BaseSiteService{
    private $geometryService;
    private $entityService;

    public function __construct($geometryServ, $es){
        $this->geometryService = $geometryServ;
        $this->entityService = $es;
        $this->schema = array(
            'geom'=>'point',
            'bsNom'=>null,
            'bsTypeId'=>null,
            'bsDate'=>'date',
            'bsDescription'=>null,
            'bsObrId'=>null,
            'metaNumerisateurId'=>null
        );
    }

    public function create($db, $data){
        $manager = $db->getManager();
        $site = new Site();
        $this->entityService->hydrate($site, $this->schema, $data);
        $manager->persist($site);
        $manager->flush();
        return $site;
    }

    public function update($db, $site, $data){
        $manager = $db->getManager();
        $this->entityService->hydrate($site, $this->schema, $data);
        $manager->flush();
        return $site;
    }

    public function remove($db, $site){
        $manager = $db->getManager();
        $manager->remove($site);
        $manager->flush();
    }
}
