<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Thesaurus
 */
class Thesaurus extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $id_type;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $fk_parent;

    /**
     * @var string
     */
    private $hierarchie;


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
     * Set id_type
     *
     * @param integer $idType
     * @return Thesaurus
     */
    public function setIdType($idType)
    {
        $this->id_type = $idType;

        return $this;
    }

    /**
     * Get id_type
     *
     * @return integer 
     */
    public function getIdType()
    {
        return $this->id_type;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Thesaurus
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return Thesaurus
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Thesaurus
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

    /**
     * Set fk_parent
     *
     * @param integer $fkParent
     * @return Thesaurus
     */
    public function setFkParent($fkParent)
    {
        $this->fk_parent = $fkParent;

        return $this;
    }

    /**
     * Get fk_parent
     *
     * @return integer 
     */
    public function getFkParent()
    {
        return $this->fk_parent;
    }

    /**
     * Set hierarchie
     *
     * @param string $hierarchie
     * @return Thesaurus
     */
    public function setHierarchie($hierarchie)
    {
        $this->hierarchie = $hierarchie;

        return $this;
    }

    /**
     * Get hierarchie
     *
     * @return string 
     */
    public function getHierarchie()
    {
        return $this->hierarchie;
    }
}
