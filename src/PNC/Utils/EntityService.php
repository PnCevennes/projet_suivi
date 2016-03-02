<?php

namespace PNC\Utils;

use Commons\Exceptions\DataObjectException;
use Symfony\Component\Yaml\Yaml;

class EntityService{

    private $geometryService;
    private $kernel;
    private $db;


    public function __construct($geomService, $kernel, $db){
        $this->geometryService = $geomService;
        $this->kernel = $kernel;
        $this->db = $db;
    }


    /*
     * retourne un manager de base de données
     */
    public function getManager(){
        return $this->db->getManager();
    }


    /*
     * Retourne une entité
     * params:
     *      $entityRepo => repository
     *      $filters => filtres de requête
     */
    public function getOne($entityRepo, $filters){
        $repo = $this->db->getRepository($entityRepo);
        return $repo->findOneBy($filters);
    }


    /*
     * Retourne une liste d'entités
     * params:
     *      $entityRepo => repository
     *      $filters => filtres de requête
     */
    public function getAll($entityRepo, $filters=null){
        $repo = $this->db->getRepository($entityRepo);
        if($filters){
            return $repo->findBy($filters);
        }
        else{
            return $repo->findAll();
        }
    }


    /*
     * insere une liste d'entités dans la DB
     * params:
     *      $entityList : liste d'entités
     *      [$manager] : manager d'entités
     *
     * $entityList = array(
     *          "chemin/vers/mapping.yml"=>array(
     *              'entity'=>instance entité,
     *              'data'=>jeu de données
     *              'refer'=>array(
     *                  'source'=>array('chemin/vers/mapping.yml', 'getter')
     *                  'dest'=>'cle data'
     *              )
     *          )
     *          ...
     *      )
     */
    public function create($entityList, $_manager=null){
        if(!$_manager){
            $manager = $this->getManager();
            $manager->getConnection()->beginTransaction();
        }
        else{
            $manager = $_manager;
        }
        $out = array();
        foreach($entityList as $schema=>$obj){
            $entity = $obj['entity'];
            $data = $obj['data'];
            if(isset($obj['refer'])){
                foreach($obj['refer'] as $ref){
                    $data[$ref['dest']] = $out[$ref['source'][0]]->$ref['source'][1]();
                }
            }
            try{
                $this->hydrate($entity, $schema, $data);
                $manager->persist($entity);
                $manager->flush();
                $out[$schema] = $entity;
            }
            catch(DataObjectException $e){
                if(!isset($errors)){
                    $errors = array();
                }
                $errors = array_merge($errors, $e->getErrors());
            }
        }
        if(!isset($errors)){
            if(!$_manager){
                $manager->getConnection()->commit();
            }
            return $out;
        }
        else{
            if(!$_manager){
                $manager->getConnection()->rollback();
            }
            throw new DataObjectException($errors);
        }
    }


    /*
     * met à jour une liste d'entités
     * params:
     *      $entityList : liste d'entités
     *      [$manager] : manager d'entités
     *
     * $entityList = array(
     *          'chemin/vers/mapping.yml'=>array(
     *              'repo'=> repository
     *              'filter' => filtre de requete de récupération
     *              'data' => jeu de données
     *          )
     *          ...
     *      )
     */
    public function update($entityList, $_manager=null){
        if(!$_manager){
            $manager = $this->getManager();
            $manager->getConnection()->beginTransaction();
        }
        else{
            $manager = $_manager;
        }
        $out = array();

        foreach($entityList as $schema=>$obj){
            $data = $obj['data'];
            $entity = $this->getOne($obj['repo'], $obj['filter']);
            if(isset($obj['refer'])){
                foreach($obj['refer'] as $ref){
                    $data[$ref['dest']] = $out[$ref['source'][0]]->$ref['source'][1]();
                }
            }
            try{
                $this->hydrate($entity, $schema, $data);
                $manager->flush();
                $out[$schema] = $entity;
            }
            catch(DataObjectException $e){
                if(!isset($errors)){
                    $errors = array();
                }
                $errors = array_merge($errors, $e->getErrors());
            }
        }

        if(!isset($errors)){
            if(!$_manager){
                $manager->getConnection()->commit();
            }
            return $out;
        }
        else{
            if(!$_manager){
                $manager->getConnection()->rollback();
            }
            throw new DataObjectException($errors);
        }
    }


    /*
     * retire une liste d'entités de la DB
     * params :
     *      $entityList : liste d'entités
     *      [$manager] : manager d'entités
     *
     * $entityList = array(
     *          "chemin/vers/mapping.yml"=>array(
     *              'repo'=> repository
     *              'filter' => filtre de requete de récupération
     *          )
     *          ...
     *      )
     */
    public function delete($entityList, $_manager=null){
        $out = array();
        if(!$_manager){
            $manager = $this->getManager();
            $manager->getConnection()->beginTransaction();
        }
        else{
            $manager = $_manager;
        }
        foreach($entityList as $schema=>$obj){
            $entity = $this->getOne($obj['repo'], $obj['filter']);
            if(!$entity){
                $errors = array($obj['repo']=>'entité introuvable');
            }
            else{
                $manager->remove($entity);
                $manager->flush();
                $out[$schema] = $entity;
            }
        }
        if(!isset($errors)){
            if(!$_manager){
                $manager->getConnection()->commit();
            }
            return $out;
        }
        else{
            if(!$_manager){
                $manager->getConnection()->rollback();
            }
            throw new DataObjectException($errors);
        }
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
            if(!isset($data[$key])){
                $data[$key] = null;
            }
            $fn = 'set' . ucwords($key);
            $value = $this->transform_from($transform, $data[$key]);
            if(method_exists($obj, $fn)){
                $obj->$fn($value);
            }
        }
        if(method_exists($obj, 'errors')){
            if($obj->errors()){
                throw new DataObjectException($obj->errors());
            }
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

    public function getGeoJsonFeature($data, $geomLabelConf, $geomName='geom'){
        $out = array('type'=>'Feature');
        $out['geometry'] = $data[$geomName];
        unset($data[$geomName]);
        $out['properties'] = $data;
        $geomLabelData = array();
        foreach($geomLabelConf['refs'] as $ref){
            $geomLabelData[] = $data[$ref];
        }
        $out['properties']['geomLabel'] = vsprintf($geomLabelConf['label'], $geomLabelData);
        return $out;
    }

    /*
     * Execute une requete native
     */
    public function execRawQuery($querystring, $params){
        $query = $this->getManager()->getConnection()->prepare($querystring);
        foreach($params as $key=>$value){
            $query->bindValue($key, $value);
        }
        $query->execute();
    }

    /*
     * Simplification pour récupérer l'ID d'un fichier contenu dans son nom
     */
    public function getFileId($fname){
        return (int) explode('_', $fname)[0];
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
        if(!isset($yaml[$ename]['fields'])){
            $yaml[$ename]['fields'] = $yaml[$ename]['id'];
        }
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


    /*
     * retourne la donnée fournie transformée selon la méthode passée en parametre
     */
    private function transform_to($method, $data){
        if(is_null($data)){
            return $data;
        }
        switch($method){
            case 'date':
                return $data->format('Y-m-d');
            case 'geom':
            case 'geometry':
                return $data->toArray();
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
                if($data == null){
                    return new \DateTime();
                }
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
            case 'integer':
                return $data !== null ? $data : 0;
            default:
                return $data;
        }
    }
}
