<?php

namespace PNC\Utils;

class ThesaurusService{

    private $db;
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }

    public function get_list($type, $nullable=true){
        $repo = $this->db->getRepository('PNCBaseAppBundle:Thesaurus');
        $res = $repo->findBy(array('id_type'=>$type), array('hierarchie'=>'ASC'));
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
            if($elem->getFkParent() != 0){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
            }
        }
        return $data;
    }
}
