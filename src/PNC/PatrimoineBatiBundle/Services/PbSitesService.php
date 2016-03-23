<?php

namespace PNC\PatrimoineBatiBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use PNC\PatrimoineBatiBundle\Entity\InfoSite;
use PNC\PatrimoineBatiBundle\Entity\SiteFichiers;


class PbSitesService{

    // doctrine
    private $db;

    public function __construct($db, $parentServ, $es, $pg, $fs){
        $this->db = $db;
        $this->parentService = $parentServ;
        $this->entityService = $es;
        $this->pagination = $pg;
        $this->fileService = $fs;
        $this->schema = '../src/PNC/PatrimoineBatiBundle/Resources/config/doctrine/InfoSite.orm.yml';
    }

    public function getFilteredList($request){
        $schema = array(
            'id'=>null,
            'bsNom'=>null,
            'bsDate'=>'date',
            'typeLieu'=>null,
            'nomObservateur'=>null,
            'bsCode'=>null,
            'bsTypeId'=>null,
            'geom'=>null
        );

        $entity = 'PNCPatrimoineBatiBundle:SiteView';

        $res = $this->pagination->filter_request($entity, $request);

        $infos = $res['filtered'];

        $out = array();

        //definition de la structure de données sous form GeoJson
        $geoLabelConf = array(
            'label'=>'<h4><a href="#/patrimoinebati/site/%s">%s<a></h4>',
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
        $info = $this->entityService->getOne('PNCPatrimoineBatiBundle:InfoSite', array('fk_bs_id'=>$id));

        if(!$info){
            throw new NotFoundHttpException();
        }
        $schema = '../src/PNC/PatrimoineBatiBundle/Resources/config/doctrine/InfoSite.orm.yml';

        $data = $this->entityService->normalize($info, $schema);

        //Récupération des informations de baseSite
        $baseSite = $this->entityService->getOne('PNCBaseAppBundle:Site', array('id'=>$id));

        if(!$info){
            throw new NotFoundHttpException();
        }
        $schema = '../src/PNC/BaseAppBundle/Resources/config/doctrine/Site.orm.yml';

        $dataBaseSite = $this->entityService->normalize($baseSite, $schema);

        //Fusion du détail du site avec Base Site
        unset($dataBaseSite['id']);
        $data = array_merge($data, $dataBaseSite);

        /*
        $l_fichiers = $this->entityService->getAll('PNCPatrimoineBatiBundle:SiteFichiers', array('site_id'=>$id));
        $fichiers = array();
        foreach($l_fichiers as $f){
            $fObj = $this->entityService->getOne('PNCBaseAppBundle:Fichiers', array('id'=>$f->getFichierId()));
            $fichiers[] = array(
                'fname' => $fObj->getId() . '_' . $fObj->getPath(),
                'commentaire' => $f->getCommentaire()
            );
        }
        $data['siteFichiers'] = $fichiers;
         */

        $data['siteFichiers'] = $this->fileService->getFichiers('patrimoinebati/site', $id);
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

        $this->fileService->record_files($site->getId(), $data['siteFichiers'], $manager);

        $manager->getConnection()->commit();

        return array('id'=>$site->getId());
    }

    public function update($id, $data){
        $repo = $this->db->getRepository('PNCPatrimoineBatiBundle:InfoSite');
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

        $this->fileService->record_files($site->getId(), $data['siteFichiers'], $manager);
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

        return array('id'=>$site->getId());

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

        $this->fileService->delete_all('patrimoinebati/site', $id);

        $this->parentService->remove($this->db, $site);
        return true;
    }
}
