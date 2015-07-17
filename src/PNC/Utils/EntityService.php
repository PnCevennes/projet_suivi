<?php

namespace PNC\Utils;

use Commons\Exceptions\DataObjectException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Debug\Exception\UndefinedMethodException;

class EntityService{

    private $geometryService;
    private $kernel;

    public function __construct($geomService, $kernel){
        $this->geometryService = $geomService;
        $this->kernel = $kernel;
    }


    /*
     * passe les données contenues dans $data à l'objet fourni $obj
     * en suivant le schéma de données fourni
     * params:
     *      obj => l'objet à "hydrater"
     *      schema => le schéma de données
     *      data => les données
     */
    public function hydrate($obj, $schema, $data){
        if(!is_array($schema)){
            $schema = $this->read_mapping($schema);
        }
        foreach($schema as $key=>$transform){
            if(isset($data[$key])){
                $fn = 'set' . ucwords($key);
                $value = $this->transform_from($transform, $data[$key]);
                if(method_exists($obj, $fn)){
                    $obj->$fn($value);
                }
            }
        }
        if($obj->errors()){
            throw new DataObjectException($obj->errors());
        }
    }


    /*
     * retourne un tableau sérialisable en JSON des données de l'entité fournie
     * params:
     *      obj => l'entité à normaliser
     *      schema => le schema de données
     */
    public function normalize($obj, $schema){
        if(!$obj){
            return array();
        }
        if(!is_array($schema)){
            $schema = $this->read_mapping($schema);
        }
        $out = array();
        foreach($schema as $key=>$transform){
            $fn = 'get' . ucwords($key);
            $value = $this->transform_to($transform, $obj->$fn());
            $out[$key] = $value;
        }
        return $out;
    }


    /*
     * lit un mapping entité et retourne le schéma de données
     */
    private function read_mapping($path){
        $file = file_get_contents($this->kernel->getRootDir() . '/' . $path);
        $yaml = Yaml::parse($file);
        $ename = array_keys($yaml)[0];
        $idT = $yaml[$ename]['id'];
        $out = array($this->camelize(array_keys($idT)[0])=>null);
        foreach($yaml[$ename]['fields'] as $key=>$value){
            $out[$this->camelize($key)] = $value['type'];
        }
        return $out;
    }

    /*
     * transforme une chaine dont les mots sont séparés par des underscore
     * en chaine camelCase
     */
    private function camelize($value){
        $s = str_replace('_', ' ', $value);
        $s = ucwords($s);
        $s[0] = strtolower($s[0]);
        return str_replace(' ', '', $s);
    }


    private function transform_to($method, $data){
        if(is_null($data)){
            return $data;
        }
        switch($method){
            case 'date': 
                return $data->format('Y-m-d');
            default:
                return $data;
        }
    }


    /*
     * agit sur les données issues d'une requete http
     * retourne la donnée fournie transformée selon la méthode passée en parametre
     * params: 
     *      method => la méthode de transformation
     *      data => la donnée à transformer
     */
    private function transform_from($method, $data){
        if(!$method){
            return $data;
        }
        switch($method){
            case 'date': 
                if(strpos($data, '/')!==false){
                    return \DateTime::createFromFormat('d/m/Y', $data);
                }
                else{
                    return \DateTime::createFromFormat('Y-m-d', substr($data, 0, 10));
                }
            case 'point':
                return $this->geometryService->getPoint($data);
            case 'linestring':
                return $this->geometryService->getLineString($data);
            case 'polygon':
                return $this->geometryService->getPolygon($data);
            default:
                return $data;
        }
    }
}
