<?php

namespace PNC\BaseAppBundle\Services;

use Commons\Exceptions\DataObjectException;

use PNC\BaseAppBundle\Entity\Site;


class BaseSiteService{
    private $geometryService;

    public function __construct($geometryServ){
        $this->geometryService = $geometryServ;
    }

    public function create($db, $data){
        $manager = $db->getManager();
        $site = new Site();
        $this->hydrate($site, $data);
        $manager->persist($site);
        $manager->flush();
        return $site;
    }

    public function update($db, $site, $data){
        $manager = $db->getManager();
        $this->hydrate($site, $data);
        $manager->flush();
        return $site;
    }

    public function remove($db, $site){
        $manager = $db->getManager();
        $manager->remove($site);
        $manager->flush();
    }

    private function hydrate($obj, $data){
        $geom = $this->geometryService->getPoint($data['geom']);
        $obj->setSiteNom($data['siteNom']);
        $obj->setTypeId($data['typeId']);
        if(strpos($data['siteDate'], '/')!==false){
            $date = \DateTime::createFromFormat('d/m/Y', $data['siteDate']);
        }
        else{
            $date = \DateTime::createFromFormat('Y-m-d', substr($data['siteDate'], 0, 10));
        }
        $obj->setSiteDate($date);
        $obj->setSiteDescription($data['siteDescription']);
        $obj->setSiteCode($data['siteCode']);
        $obj->setObservateurId($data['observateurId']);
        $obj->setGeom($geom);

        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
