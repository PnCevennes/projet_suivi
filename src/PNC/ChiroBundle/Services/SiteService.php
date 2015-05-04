<?php

namespace PNC\ChiroBundle\Services;

use Commons\Exceptions\DataObjectException;

class SiteService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }

    public function getList(){

    }

    public function getOne($id){

    }

    public function create($data){
    }

    public function update($id, $data){
    }

    public function remove($id){
    }

    private function populateBase($obj, $data){
    }

    private function populateExt($obj, $data){
    }
}
