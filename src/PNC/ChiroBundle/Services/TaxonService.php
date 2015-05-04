<?php

namespace PNC\ChiroBundle\Services;

class TaxonService{
    // doctrine
    private $db;

    // normalizer
    private $norm;

    public function __construct$($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }
}


