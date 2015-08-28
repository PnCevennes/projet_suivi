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

    public function __construct($db, $obsServ, $parentServ, $es, $pg){
        $this->db = $db;
        $this->obsService = $obsServ;
        $this->parentService = $parentServ;
        $this->entityService = $es;
        $this->pagination = $pg;
        $this->schema = array(
            'cisFrequentation'=>null,
            'cisMenace'=>null,
            'cisMenaceCmt'=>null,
            'cisContactNom'=>null,
            'cisContactPrenom'=>null,
            'cisContactAdresse'=>null,
            'cisContactCodePostal'=>null,
            'cisContactVille'=>null,
            'cisContactTelephone'=>null,
            'cisContactPortable'=>null,
            'cisContactCommentaire'=>null
        );

    }

    public function getFilteredList($request){
        $schema = array(
            'id'=>null,
            'bsNom'=>null,
            'bsDate'=>'date',
            'dernObs'=>'date',
            'nbObs'=>null,
            'nomObservateur'=>null,
            'bsCode'=>null,
            'bsTypeId'=>null,
            'geom'=>null,
        );

        $entity = 'PNCChiroBundle:SiteView';

        $res = $this->pagination->filter_request($entity, $request);

        $infos = $res['filtered'];

        $out = array();

        // definition de la structure de données sous form GeoJson
        $geoLabelConf = array(
            'label'=>'<h4><a href="#/chiro/site/%s">%s<a></h4>',
            'refs'=>array('id', 'bsNom')
        );

        foreach($infos as $info){
            $out[] = $this->entityService->getGeoJsonFeature(
                $this->entityService->normalize($info, $schema),
                $geoLabelConf, 
                'geom');
        }

        return array('total'=>$res['total'], 'filteredCount'=>$res['filteredCount'], 'filtered'=>$out);
    }

    public function getOne($id){
        $info = $this->entityService->getOne('PNCChiroBundle:SiteView', array('id'=>$id));
        if(!$info){
            throw new NotFoundHttpException();
        }
        $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/SiteView.orm.yml';
        $data = $this->entityService->normalize($info, $schema);

        $data['geom'] = array($data['geom']['coordinates']);
        return $data;
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
            $this->entityService->hydrate($infoSite, $this->schema, $data);
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
        $infoSite = $repo->findOneBy(array('fk_bs_id'=>$id));
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
            $this->entityService->hydrate($infoSite, $this->schema, $data);
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
        $infoSite = $repo->findOneBy(array('fk_bs_id'=>$id));
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
}
