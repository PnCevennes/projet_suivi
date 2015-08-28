<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Site
 */
class Site extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $bs_nom;

    /**
     * @var integer
     */
    private $bs_obr_id;

    /**
     * @var integer
     */
    private $bs_type_id;

    /**
     * @var string
     */
    private $bs_code;

    /**
     * @var \DateTime
     */
    private $bs_date;

    /**
     * @var string
     */
    private $bs_description;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var string
     */
    private $ref_commune;

    /**
     * @var \DateTime
     */
    private $meta_create_timestamp;

    /**
     * @var \DateTime
     */
    private $meta_update_timestamp;

    /**
     * @var integer
     */
    private $meta_numerisateur_id;


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
     * Set bs_nom
     *
     * @param string $bsNom
     * @return Site
     */
    public function setBsNom($bsNom)
    {
        $this->bs_nom = $bsNom;

        return $this;
    }

    /**
     * Get bs_nom
     *
     * @return string 
     */
    public function getBsNom()
    {
        return $this->bs_nom;
    }

    /**
     * Set bs_obr_id
     *
     * @param integer $bsObrId
     * @return Site
     */
    public function setBsObrId($bsObrId)
    {
        $this->bs_obr_id = $bsObrId;

        return $this;
    }

    /**
     * Get bs_obr_id
     *
     * @return integer 
     */
    public function getBsObrId()
    {
        return $this->bs_obr_id;
    }

    /**
     * Set bs_type_id
     *
     * @param integer $bsTypeId
     * @return Site
     */
    public function setBsTypeId($bsTypeId)
    {
        $this->bs_type_id = $bsTypeId;

        return $this;
    }

    /**
     * Get bs_type_id
     *
     * @return integer 
     */
    public function getBsTypeId()
    {
        return $this->bs_type_id;
    }

    /**
     * Set bs_code
     *
     * @param string $bsCode
     * @return Site
     */
    public function setBsCode($bsCode)
    {
        $this->bs_code = $bsCode;

        return $this;
    }

    /**
     * Get bs_code
     *
     * @return string 
     */
    public function getBsCode()
    {
        return $this->bs_code;
    }

    /**
     * Set bs_date
     *
     * @param \DateTime $bsDate
     * @return Site
     */
    public function setBsDate($bsDate)
    {
        $this->bs_date = $bsDate;

        return $this;
    }

    /**
     * Get bs_date
     *
     * @return \DateTime 
     */
    public function getBsDate()
    {
        return $this->bs_date;
    }

    /**
     * Set bs_description
     *
     * @param string $bsDescription
     * @return Site
     */
    public function setBsDescription($bsDescription)
    {
        $this->bs_description = $bsDescription;

        return $this;
    }

    /**
     * Get bs_description
     *
     * @return string 
     */
    public function getBsDescription()
    {
        return $this->bs_description;
    }

    /**
     * Set geom
     *
     * @param geometry $geom
     * @return Site
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return geometry 
     */
    public function getGeom()
    {
        return $this->geom;
    }

    /**
     * Set ref_commune
     *
     * @param string $refCommune
     * @return Site
     */
    public function setRefCommune($refCommune)
    {
        $this->ref_commune = $refCommune;

        return $this;
    }

    /**
     * Get ref_commune
     *
     * @return string 
     */
    public function getRefCommune()
    {
        return $this->ref_commune;
    }

    /**
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return Site
     */
    public function setMetaCreateTimestamp($metaCreateTimestamp)
    {
        $this->meta_create_timestamp = $metaCreateTimestamp;

        return $this;
    }

    /**
     * Get meta_create_timestamp
     *
     * @return \DateTime 
     */
    public function getMetaCreateTimestamp()
    {
        return $this->meta_create_timestamp;
    }

    /**
     * Set meta_update_timestamp
     *
     * @param \DateTime $metaUpdateTimestamp
     * @return Site
     */
    public function setMetaUpdateTimestamp($metaUpdateTimestamp)
    {
        $this->meta_update_timestamp = $metaUpdateTimestamp;

        return $this;
    }

    /**
     * Get meta_update_timestamp
     *
     * @return \DateTime 
     */
    public function getMetaUpdateTimestamp()
    {
        return $this->meta_update_timestamp;
    }

    /**
     * Set meta_numerisateur_id
     *
     * @param integer $metaNumerisateurId
     * @return Site
     */
    public function setMetaNumerisateurId($metaNumerisateurId)
    {
        $this->meta_numerisateur_id = $metaNumerisateurId;

        return $this;
    }

    /**
     * Get meta_numerisateur_id
     *
     * @return integer 
     */
    public function getMetaNumerisateurId()
    {
        return $this->meta_numerisateur_id;
    }
}
