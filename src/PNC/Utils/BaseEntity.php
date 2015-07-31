<?php

namespace PNC\Utils;

class BaseEntity{

    //liste des erreurs
    protected $_errors = array();

    public function errors(){
        /*
         * retourne la liste des erreurs
         */

        return $this->_errors;
    }

    protected function add_error($varName, $errMsg){
        $this->_errors[$varName] = $errMsg;
    }
}
