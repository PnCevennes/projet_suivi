<?php

namespace PNC\PatrimoineBatiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * SiteView
 */
class SiteView   extends BaseEntity
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
    private $denomination;

    /**
     * @var array
     */
    private $geom;

    /**
     * @var string
     */
    private $nom_observateur;

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
    private $type_lieu;

    /**
     * @var string
     */
    private $bs_description;

    /**
     * @var integer
     */
    private $pb_source;


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
     * @return SiteView
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
     * Set bs_code
     *
     * @param string $bsCode
     * @return SiteView
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
     * @return SiteView
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
     * Set denomination
     *
     * @param string $denomination
     * @return SiteView
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set geom
     *
     * @param array $geom
     * @return SiteView
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return array
     */
    public function getGeom()
    {
        return $this->geom;
    }

    /**
     * Set nom_observateur
     *
     * @param string $nomObservateur
     * @return SiteView
     */
    public function setNomObservateur($nomObservateur)
    {
        $this->nom_observateur = $nomObservateur;

        return $this;
    }

    /**
     * Get nom_observateur
     *
     * @return string
     */
    public function getNomObservateur()
    {
        return $this->nom_observateur;
    }

    /**
     * Set bs_obr_id
     *
     * @param integer $bsObrId
     * @return SiteView
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
     * @return SiteView
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
     * Set type_lieu
     *
     * @param string $typeLieu
     * @return SiteView
     */
    public function setTypeLieu($typeLieu)
    {
        $this->type_lieu = $typeLieu;

        return $this;
    }

    /**
     * Get type_lieu
     *
     * @return string
     */
    public function getTypeLieu()
    {
        return $this->type_lieu;
    }

    /**
     * Set bs_description
     *
     * @param string $bsDescription
     * @return SiteView
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
     * Set pb_source
     *
     * @param integer $pbSource
     * @return SiteView
     */
    public function setPbSource($pbSource)
    {
        $this->pb_source = $pbSource;

        return $this;
    }

    /**
     * Get pb_source
     *
     * @return integer
     */
    public function getPbSource()
    {
        return $this->pb_source;
    }
}
