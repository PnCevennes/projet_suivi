<?php

namespace PNC\ChiroBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\ChiroBundle\Entity\InfoSite;
use PNC\ChiroBundle\Entity\SiteFichiers;


class SiteService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct($db, $norm, $obsServ, $parentServ){
        $this->db = $db;
        $this->norm = $norm;
        $this->obsService = $obsServ;
        $this->parentService = $parentServ;
    }

    public function getList(){
        $repo = $this->db->getRepository('PNCChiroBundle:SiteView');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'siteNom'=>$info->getSiteNom(),
                'siteDate'=>!is_null($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '',
                'dernObs'=>!is_null($info->getDernObs()) ? $info->getDernObs()->format('Y-m-d'): '',
                'nomObservateur'=>$info->getNomObservateur(),
                'siteCode'=>$info->getSiteCode(),
                'typeLieu'=>$info->getTypeLieu(),
            );
            $out_item['geometry'] = $info->getGeom();

            $out_item['properties']['geomLabel'] = sprintf('<a href="#/chiro/site/%s">%s</a>',
                $info->getId(), $info->getSiteNom());
            $out[] = $out_item;
        }
        return $out;


    }

    public function getOne($id){
        $repo = $this->db->getRepository('PNCChiroBundle:SiteView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }

        $out_item = $this->norm->normalize($info, array('siteDate', 'geom', 'dernObs', 'siteAmenagement'));
        $out_item['siteAmenagement'] = $info->getSiteAmenagement();
        $out_item['siteDate'] = !is_null($info->getSiteDate()) ? $info->getSiteDate()->format('Y-m-d'): '';
        $out_item['dernObs'] = !is_null($info->getDernObs()) ? $info->getDernObs()->format('Y-m-d'): '';
        $out_item['geom'] = array($info->getGeom()['coordinates']);
        return $out_item;
    }

    public function create($data){
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $errors = array();
        $site = null;

        $infoSite = new InfoSite();
        try{
            $site = $this->parentService->create($this->db, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
        }
        try{
            $this->hydrate($infoSite, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }
        $infoSite->setParentSite($site);
        $manager->persist($infoSite);
        $manager->flush();
        $manager->getConnection()->commit();
        
        $errors = $this->_record_amenagement($site, $data['siteAmenagement']);
        if($errors){
            //print_r($errors);
        }
        
        return array('id'=>$site->getId());
    }

    public function update($id, $data){
        $repo = $this->db->getRepository('PNCChiroBundle:InfoSite');
        $infoSite = $repo->findOneBy(array('site_id'=>$id));
        if(!$infoSite){
            return null;
        }

        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $site = $infoSite->getParentSite();
        $errors = array();
        try{
            $site = $this->parentService->update($this->db, $site, $data);
        }
        catch(DataObjectException $e){
            $errors = $e->getErrors();
        }
        try{
            $this->hydrate($infoSite, $data);
            $manager->flush();
            $manager->getConnection()->commit();
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
            throw new DataObjectException($errors);
        }

        $errors = $this->_record_amenagement($site, $data['siteAmenagement']);
        if($errors){
            //print_r($errors);
        }
        return array('id'=>$site->getId());

    }

    private function _record_amenagement($site, $data){
        $errors = array();
        // enregistrement des fichiers liés

        $manager = $this->db->getManager();

        // suppression des liens existants
        $delete = $manager->getConnection()->prepare('DELETE FROM chiro.rel_chirosite_fichiers WHERE site_id=:siteid');
        $delete->bindValue('siteid', $site->getId());
        $delete->execute();

        foreach($data as $fichier){
            $fich_ = explode('_', $fichier);
            $fich_id = (int) $fich_[0];
            try{
                $fichier = new SiteFichiers();
                $fichier->setSiteId($site->getId());
                $fichier->setFichierId($fich_id);
                $manager->persist($fichier);
                $manager->flush();
            }
            catch(\Exception $e){
                $errors[] = $e->getMessage();
            }
        }
        return $errors;
    }

    public function remove($id, $cascade=false){
        $repo = $this->db->getRepository('PNCChiroBundle:InfoSite');
        $infoSite = $repo->findOneBy(array('site_id'=>$id));
        if(!$infoSite){
            return false;
        }
        $observations = $this->obsService->getList($id);
        if($cascade){
            foreach($observations as $obs){
                $this->obsService->remove($obs['id'], $cascade);
            }
        }
        else{
            if($observations){
                throw new CascadeException();
            }
        }
        $site = $infoSite->getParentSite();

        $manager = $this->db->getManager();
        $manager->remove($infoSite);
        $manager->flush();
        $this->parentService->remove($this->db, $site);
        return true;

    }

    private function hydrate($obj, $data){
        $obj->setSiteFrequentation($data['siteFrequentation']);
        $obj->setSiteMenace($data['siteMenace']);
        $obj->setSiteMenaceCmt($data['siteMenaceCmt']);
        $obj->setContactNom($data['contactNom']);
        $obj->setContactPrenom($data['contactPrenom']);
        $obj->setContactAdresse($data['contactAdresse']);
        $obj->setContactCodePostal($data['contactCodePostal']);
        $obj->setContactVille($data['contactVille']);
        $obj->setContactTelephone($data['contactTelephone']);
        $obj->setContactPortable($data['contactPortable']);
        $obj->setContactCommentaire($data['contactCommentaire']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
