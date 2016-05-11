<?php

namespace PNC\Utils;

use Commons\Exceptions\DataObjectException;
use Symfony\Component\Yaml\Yaml;

use PNC\BaseAppBundle\Entity\Fichier;

class FileService{
    private $db;
    private $upload_basedir;

    public function __construct($db, $es, $kernel){
        $this->db = $db;
        $this->entityService = $es;
        $this->upload_basedir = $kernel->getContainer()->getParameter('upload_directory');
    }

    public function upload($req){
        $updir = $this->upload_basedir . '/' . $req->query->get('target', '');
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        foreach($req->files as $file){
            try{
                $fichier = new Fichier();
                $fichier->setPath($file->getClientOriginalName());
                $fichier->setFtype($req->query->get('target', ''));
                $manager->persist($fichier);
                $manager->flush();

                $filename = $fichier->getId() . '_' . $fichier->getPath();

                $file->move($updir, $filename);

                $manager->getConnection()->commit();

                return array(
                    'id'=>$fichier->getId(),
                    'path'=>$filename,
                );
            }
            catch(DataObjectException $e){
                $this->db->getConnection()->rollback();
                throw new DataObjectException($e->getErrors());
            }
            catch(\Exception $e){
                $this->db->getConnection()->rollback();
                throw new DataObjectException(array('path'=>"Erreur d'écriture inconnue."));
            }
        }
    }

    /*
    public function remove($req, $file_id, $manager){
        $_manager = $manager;
        $updir = $this->upload_basedir . '/' . $req->query->get('target', '');
        $id = substr($file_id, 0, strpos($file_id, '_'));
        $deleted = false;
        $repo = $this->db->getRepository('PNCBaseAppBundle:Fichier');
        $fich = $repo->findOneById($id);

        if(!$manager){
            $_manager = $this->db->getManager();
            $_manager->getConnection()->beginTransaction();
        }


        $_manager->remove($fich);
        $_manager->flush();

        if(!$manager){
            $_manager->getConnection()->commit();
        }

        $target_directory = $req->query->get('target', '');
        $fdir = $updir . '/' . $file_id;
        if(file_exists($fdir)){
            unlink($fdir);
            $deleted = true;
        }
        return array(
            'id'=>$file_id, 
            'fichier'=>$fich,
            'fdir'=>$fdir,
            'deleted'=>$deleted
        );
    }
     */

    public function record_files($obj_id, $data, $manager=null){
        if(count($data) == 0) return;
        $repo = $this->db->getRepository('PNCBaseAppBundle:Fichier');
        $prev_files = $repo->findBy(array('ftype'=>$data[0]['ftype'], 'id_objet'=>$obj_id));
        $prev_ids = array();
        $update_ids = array();
        foreach($prev_files as $file){
            $prev_ids[] = $file->getId();
        }
        foreach($data as $fichier){
            if(isset($fichier['id'])){
                $update_ids[] = $fichier['id'];
            }
            $this->record($obj_id, $fichier, $manager);
        }
        $a_effacer = array_filter(
            $prev_files, 
            function($x) use ($update_ids){
                return !in_array($x->getId(), $update_ids);
            });
        foreach($a_effacer as $id_eff){
            $this->delete_file($id_eff, $manager);
        }
    }

    public function delete_file($id, $manager=null){
        $_manager = $manager;

        $repo = $this->db->getRepository('PNCBaseAppBundle:Fichier');
        $fich = $repo->findOneById($id);

        if(!$manager){
            $_manager = $this->db->getManager();
            $_manager->getConnection()->beginTransaction();
        }

        $filename = sprintf(
            '%s/%s/%s_%s',
            $this->upload_basedir,
            $fich->getFtype(),
            $fich->getId(),
            $fich->getPath()
        );

        $_manager->remove($fich);
        $_manager->flush();

        unlink($filename);

        if(!$manager){
            $_manager->getConnection()->commit();
        }
    }

    public function delete_all($type, $obj_id, $manager=null){
        $_manager = $manager;
        $repo = $this->db->getRepository('PNCBaseAppBundle:Fichier');
        $files = $repo->findAll(array('id_objet'=>$obj_id, 'ftype'=>$type));

        if(!$manager){
            $_manager = $this->db->getManager();
            $_manager->getConnection()->beginTransaction();
        }

        foreach($files as $fich){
            $this->delete_file($fich->getId(), $_manager);
        }

        if(!$manager){
            $_manager->getConnection()->commit();
        }

    }

    
    public function record($obj_id, $data, $manager=null){
        //fourniture ou non du manager pour une transaction globale
        $_manager = $manager;
        $repo = $this->db->getRepository('PNCBaseAppBundle:Fichier');
        if(isset($data['id'])){
            $fich = $repo->findOneById($data['id']);
        }
        else{
            //cas de fichier joints par url
            $fich = new Fichier();
        }

        // manager non fourni -> transaction locale
        if(!$_manager){
            $_manager = $this->db->getManager();
            $_manager->getConnection()->beginTransaction();
        }

        $fich
            ->setFType($data['ftype'])
            ->setIdObjet($obj_id)
            ->setUrl(isset($data['url']) ? $data['url'] : '')
            ->setTitre(isset($data['titre']) ? $data['titre']: '')
            ->setDescription(isset($data['description']) ? $data['description'] : '');

        // cas fichier joint par url
        if(!$fich->getId()){
            $_manager->persist($fich);
        }
        $_manager->flush();
        if(!$manager){
            $_manager->getConnection()->commit();
        }
        return $fich->getId();

    }

    public function getFichiers($type, $obj_id){
        $mapping = 'PNCBaseAppBundle:Fichier';
        $schema = '../src/PNC/BaseAppBundle/Resources/config/doctrine/Fichier.orm.yml';
        $fichiers = $this->entityService->getAll(
            $mapping, 
            array(
                'ftype'=>$type, 
                'id_objet'=>$obj_id
            )
        );
        $out = array();
        foreach($fichiers as $f){
            $out[] = $this->entityService->normalize($f, $schema);
        }
        return $out;
    }

    /*
     * Simplification pour récupérer l'ID d'un fichier contenu dans son nom
     */
    public function getFileId($fname){
        return (int) explode('_', $fname)[0];
    }

}
