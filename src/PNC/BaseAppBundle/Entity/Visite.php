<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Visite
 */
class Visite extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $bv_date;

    /**
     * @var string
     */
    private $bv_commentaire;

    /**
     * @var integer
     */
    private $bv_id_table_src;

    /**
     * @var integer
     */
    private $meta_numerisateur_id;

    /**
     * @var integer
     */
    private $fk_bs_id;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var string
     */
    private $bv_ref_commune;

    /**
     * @var \DateTime
     */
    private $meta_create_timestamp;

    /**
     * @var \DateTime
     */
    private $meta_update_timestamp;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $observateurs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set bv_date
     *
     * @param \DateTime $bvDate
     * @return Visite
     */
    public function setBvDate($bvDate)
    {
        $this->bv_date = $bvDate;

        return $this;
    }

    /**
     * Get bv_date
     *
     * @return \DateTime 
     */
    public function getBvDate()
    {
        return $this->bv_date;
    }

    /**
     * Set bv_commentaire
     *
     * @param string $bvCommentaire
     * @return Visite
     */
    public function setBvCommentaire($bvCommentaire)
    {
        $this->bv_commentaire = $bvCommentaire;

        return $this;
    }

    /**
     * Get bv_commentaire
     *
     * @return string 
     */
    public function getBvCommentaire()
    {
        return $this->bv_commentaire;
    }

    /**
     * Set bv_id_table_src
     *
     * @param integer $bvIdTableSrc
     * @return Visite
     */
    public function setBvIdTableSrc($bvIdTableSrc)
    {
        $this->bv_id_table_src = $bvIdTableSrc;

        return $this;
    }

    /**
     * Get bv_id_table_src
     *
     * @return integer 
     */
    public function getBvIdTableSrc()
    {
        return $this->bv_id_table_src;
    }

    /**
     * Set meta_numerisateur_id
     *
     * @param integer $metaNumerisateurId
     * @return Visite
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

    /**
     * Set fk_bs_id
     *
     * @param integer $fkBsId
     * @return Visite
     */
    public function setFkBsId($fkBsId)
    {
        $this->fk_bs_id = $fkBsId;

        return $this;
    }

    /**
     * Get fk_bs_id
     *
     * @return integer 
     */
    public function getFkBsId()
    {
        return $this->fk_bs_id;
    }

    /**
     * Set geom
     *
     * @param geometry $geom
     * @return Visite
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
     * @return Visite
     */
    public function setBvRefCommune($refCommune)
    {
        $this->bv_ref_commune = $refCommune;

        return $this;
    }

    /**
     * Get ref_commune
     *
     * @return string 
     */
    public function getBvRefCommune()
    {
        return $this->bv_ref_commune;
    }

    /**
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return Visite
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
     * @return Visite
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
     * Add observateurs
     *
     * @param \PNC\BaseAppBundle\Entity\Observateurs $observateurs
     * @return Visite
     */
    public function addObservateur(\PNC\BaseAppBundle\Entity\Observateurs $observateurs)
    {
        $this->observateurs[] = $observateurs;

        return $this;
    }

    /**
     * Remove observateurs
     *
     * @param \PNC\BaseAppBundle\Entity\Observateurs $observateurs
     */
    public function removeObservateur(\PNC\BaseAppBundle\Entity\Observateurs $observateurs)
    {
        $this->observateurs->removeElement($observateurs);
    }

    /**
     * Get observateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservateurs()
    {
        return $this->observateurs;
    }
}
