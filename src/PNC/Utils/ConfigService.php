<?php

namespace PNC\Utils;

use Symfony\Component\Yaml\Yaml;

class ConfigService{

    private $thesaurus;

    public function __construct($th){
        $this->thesaurus = $th;
    }

    public function get_config($path){

        $yaml = Yaml::parse(file_get_contents($path));
        if(isset($yaml['groups'])){
            foreach($yaml['groups'] as &$group){
                $this->parse_list($group['fields']);
            }
        }
        if(isset($yaml['filtering'])){
            $this->parse_list($yaml['filtering']['fields']);
        }
        if(isset($yaml['fields'])){
            $this->parse_list($yaml['fields']);
        }
        return $yaml;
    }

    private function parse_list(&$list){
        foreach($list as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['type'] == 'select' && isset($field['thesaurusID'])){
                $field['options']['choices'] = $this->thesaurus->get_list($field['thesaurusID']);
                unset($field['thesaurusID']);
            }
        }
    }
}
