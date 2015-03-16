<?php

namespace PNC\BaseAppBundle\Services;

class ObservationService{
    private $db;
    private $normalizer;

    public function __construct($db, $normalizer){
        $this->db = $db;
        $this->normalizer = $normalizer;
    }

    public function normalize($data){
        /*
         * retourne les objets "Observation" fournis sous forme de liste serialisable en Json
         */
        $out = array();
        foreach($data as $item){
            $outitem = $this->normalizer->normalize($item, array('obsDate', 'site', 'observateurs'));
            $outitem['obsDate'] = $item->getObsDate();
            $outitem['observateurs'] = array();
            $outitem['geom'] = $item->geom;
            foreach($item->getObservateurs() as $obr){
                $outitem['observateurs'][] = $this->normalizer->normalize($obr, array());
            }
            $out[$item->getId()] = $outitem;
        }
        return $out;
    }

    public function getGeoms($objs){
        /*
         * ajoute la géométrie GeoJson désérialisée aux objets fournis
         */
        $ids = implode(', ', array_keys($objs));
        $conn = $this->db->getEntityManager()->getConnection();
        $res = $conn->fetchAll('select obs_id, st_asGeoJson(geom) as geometry from pnc.obs_geometries where obs_id in ('.$ids.')', array());
        foreach($res as $item){
            $objs[$item['obs_id']]->geom = json_decode($item['geometry']);
        }
    }

    public function getBySite($site_id){
        /*
         * retourne les observations associées à un site
         */
        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT o, s, r
            FROM PNCBaseAppBundle:Observation o
            JOIN o.site s
            JOIN o.observateurs r
            WHERE s.id = ?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $site_id);
        $out = array();
        foreach($qr->getResult() as $item){
            $out[$item->getId()] = $item;
        }
        $this->getGeoms($out);
        return $out;
    }

    public function getByObservateur($obs_id){
        /*
         * retourne la liste des observations faites par un observateur
         */
        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT o, s, r
            FROM PNCBaseAppBundle:Observation o
            JOIN o.site s
            JOIN o.observateurs r
            WHERE r.id = ?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $obs_id);
        $out = array();
        foreach($qr->getResult() as $item){
            $out[$item->getId()] = $item;
        }
        $this->getGeoms($out);
        return $out;
    }

    public function getByDate($date){
        /*
         * retourne la liste des observations à une date donnée
         */
        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT o, s, r
            FROM PNCBaseAppBundle:Observation o
            JOIN o.site s
            JOIN o.observateurs r
            WHERE o.obs_date = ?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $date);
        $out = array();
        foreach($qr->getResult() as $item){
            $out[$item->getId()] = $item;
        }
        $this->getGeoms($out);
        return $out;
    }

    public function getById($id){
        $repo = $this->db->getEntityManager();
        $dql_qr = '
            SELECT o, s, r
            FROM PNCBaseAppBundle:Observation o
            JOIN o.site s
            JOIN o.observateurs r
            WHERE o.id= ?1';
        $qr = $repo->createQuery($dql_qr);
        $qr->setParameter(1, $id);
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

