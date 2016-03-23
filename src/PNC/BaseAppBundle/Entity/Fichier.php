<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fichiers
 */
class Fichier
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $ftype;

    /**
     * @var integer
     */
    private $id_objet;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $description;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ftype
     *
     * @param string $ftype
     * @return Fichiers
     */
    public function setFtype($ftype)
    {
        $this->ftype = $ftype;

        return $this;
    }

    /**
     * Get ftype
     *
     * @return string 
     */
    public function getFtype()
    {
        return $this->ftype;
    }

    /**
     * Set id_objet
     *
     * @param integer $idObjet
     * @return Fichiers
     */
    public function setIdObjet($idObjet)
    {
        $this->id_objet = $idObjet;

        return $this;
    }

    /**
     * Get id_objet
     *
     * @return integer 
     */
    public function getIdObjet()
    {
        return $this->id_objet;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Fichiers
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Fichiers
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Fichiers
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Fichiers
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
