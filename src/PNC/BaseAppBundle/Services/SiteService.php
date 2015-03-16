<?php

namespace PNC\BaseAppBundle\Services;

class SiteService{
    private $db;
    private $normalizer;

    public function __construct($db, $normalizer){
        $this->db = $db;
        $this->normalizer = $normalizer;
    }

    public function normalize($data){
        /*
         * retourne les objets "Site" fournis sous forme de liste serialisable en Json
         */
        $out = array();
        foreach($data as $res){
            $outitem=$this->normalizer->normalize($res, array('siteDate', 'observateur', 'siteType', 'siteApp', 'geom'));
            $outitem['geom'] = $res->geom;
            $outitem['siteDate'] = $res->getSiteDate();
            $outitem['observateur'] = $this->normalizer->normalize($res->getObservateur(), array());
            $outitem['app'] = array();
            $outitem['siteType'] = $this->normalizer->normalize($res->getSiteType(), array());
            foreach($res->getSiteApp() as $app){
                $outitem['app'][] = $this->normalizer->normalize($app, array());
            }
            $out[$res->getId()] = $outitem;
        }
        return $out;
    }

    public function getGeoms($objs){
        /*
         * ajoute la géométrie GeoJson désérialisée aux objets fournis
         */
        $ids = implode(', ', array_keys($objs));
        $conn = $this->db->getEntityManager()->getConnection();
        $res = $conn->fetchAll('select site_id, st_asGeoJson(geom) as geometry from pnc.sites_geometries where site_id in ('.$ids.')', array());
        foreach($res as $item){
            $objs[$item['site_id']]->geom = json_decode($item['geometry']);
        }
    }

    public function getById($id){
        /*
         * retourne l'objet "Site" associé à $id
         */
        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT s, a, o, t
            FROM PNCBaseAppBundle:Site s 
            JOIN s.site_app a 
            JOIN s.observateur o
            JOIN s.site_type t
            WHERE s.id=?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $id);
        $out = array();
        foreach($qr->getResult() as $item){
            $out[$item->getId()] = $item;
        }
        $this->getGeoms($out);
        return $out;
    }

    public function getListByApp($app_id){
        /*
         * Retourne la liste des sites liée à une application 
         */

        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT s, a, o, t
            FROM PNCBaseAppBundle:Site s 
            JOIN s.site_app a
            JOIN s.observateur o
            JOIN s.site_type t
            WHERE a.id=?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $app_id);
        $out = array();
        foreach($qr->getResult() as $item){
            $out[$item->getId()] = $item;
        }
        $this->getGeoms($out);
            
        return $out;
    }

    public function save($data){
        //TODO
    }

    public function delete($data){
        //TODO
    }
}
