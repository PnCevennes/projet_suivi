<?php

namespace PNC\Utils;


class PaginationService{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function filter_request($entity, $request, $cpl=null){
        $filters = json_decode($request->query->get('filters'), true);
        $page = $request->query->get('page', 0);
        $limit = $request->query->get('limit', null);
        $fields = array();

        if($filters){
            foreach($filters as $filter){
                if($filter['item'] == 'type_id' && $filter['value'] == 0){
                    continue;
                }
                $fields[] = array(
                    'name'=>$filter['item'],
                    'compare'=>$filter['filter'],
                    'value'=>$filter['value']
                );
            }
            if($cpl){
                foreach($cpl as $c){
                    $fields[] = $c;
                }
            }
        }
        else{
            if($cpl){
                $fields = $cpl;
            }
        }

        return $this->filter($entity, $fields, $page, $limit, $cpl);
    }

    public function filter($entity, $fields, $curPage=null, $maxResults=null, $cpl=null){
        /*
         * fields : array(
         *      array(
         *          'compare'=>'>,<,=,!=,between,like',
         *          'name'=>'fieldName',
         *          'value'=> mixed
         *      ),
         * )
         */
        $qa = $this->db->getEntityManager()->createQueryBuilder();
        $qb = $this->db->getEntityManager()->createQueryBuilder();
        $qj = $this->db->getEntityManager()->createQueryBuilder();

        //nombre total d'entités
        $qc = $qa->select('count(x)')->from($entity, 'x');
        if($cpl){
            foreach($cpl as $k=>$c){
                $_f = $this->createFilter($qc, $k, $c);
                if($_f){
                    $qc->andWhere($_f);
                }
            }
        }
        $nb = $qc->getQuery()->getSingleResult();

        //nombre filtré d'entités
        $qk = $qj->select('count(x)')->from($entity, 'x');
        foreach($fields as $key=>$field){
            $_filter = $this->createFilter($qk, $key, $field);
            if($_filter){
                $qk->andWhere($_filter);
            }
        }
        $nbFiltered = $qk->getQuery()->getSingleResult();

        //entités paginées
        $qr = $qb->select('x')->from($entity, 'x');
        if($maxResults !== 'null' && $maxResults !== 'undefined'){
            if($curPage !== 'null'){
                $qr->setFirstResult($curPage*$maxResults);
                $qr->setMaxResults($maxResults);
            }
        }
        foreach($fields as $key=>$field){
            $_filter = $this->createFilter($qr, $key, $field);
            if($_filter){
                $qr->andWhere($_filter);
            }
        }
        $result = $qr->getQuery()->getResult();
        return array('total'=>$nb[1], 'filteredCount'=>$nbFiltered[1], 'filtered'=>$result);
    }

    public function createFilter($qr, $key, $field){
        $name = 'x.' . $field['name'];
        switch($field['compare']){
            case '=':   $qi = $qr->expr()->eq($name, ':v'.$key);
                        break;
            case '!=':  $qi = $qr->expr()->neq($name, ':v'.$key);
                        break;

            case '<':   $qi = $qr->expr()->lt($name, ':v'.$key);
                        break;
            case '<=':  $qi = $qr->expr()->lte($name, ':v'.$key);
                        break;
            case '>':   $qi = $qr->expr()->gt($name, ':v'.$key);
                        break;
            case '>=':  $qi = $qr->expr()->gte($name, ':v'.$key);
                        break;
            case 'like': $qi = $qr->expr()->like($name, ':v'.$key);
                        break;
            case 'between': if($field['value'][0] && $field['value'][1]){
                                $qi = $qr->expr()->between($name, "'".$field['value'][0]."'", "'".$field['value'][1]."'");
                                return $qi;
                            }
                            return;
            case 'in': $qi = $qr->expr()->in($name, ':v'.$key);
                        break;

            default: $qi = $qr->expr()->eq($name, ':v'.$key);
        }
        $qr->setParameter('v'.$key, $field['value']);
        return $qi;
    }
}
