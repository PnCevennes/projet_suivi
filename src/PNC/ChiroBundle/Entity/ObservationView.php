<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservationView
 */
class ObservationView
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fk_bs_id;

    /**
     * @var string
     */
    private $bs_nom;

    /**
     * @var \DateTime
     */
    private $bv_date;

    /**
     * @var integer
     */
    private $meta_numerisateur_id;

    /**
     * @var string
     */
    private $numerisateur;

    /**
     * @var string
     */
    private $bv_commentaire;

    /**
     * @var integer
     */
    private $bv_id_table_src;

    /**
     * @var float
     */
    private $cvc_temperature;

    /**
     * @var float
     */
    private $cvc_humidite;

    /**
     * @var integer
     */
    private $nb_taxons;

    /**
     * @var integer
     */
    private $abondance;

    /**
     * @var integer
     */
    private $cvc_mod_id;

    /**
     * @var \DateTime
     */
    private $meta_create_timestamp;

    /**
     * @var \DateTime
     */
    private $meta_update_timestamp;

    /**
     * @var array
     */
    private $ref_commune;

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
     * Set id
     *
     * @param integer $id
     * @return ObservationView
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set fk_bs_id
     *
     * @param integer $fkBsId
     * @return ObservationView
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
     * Set bs_nom
     *
     * @param string $bsNom
     * @return ObservationView
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
     * Set bv_date
     *
     * @param \DateTime $bvDate
     * @return ObservationView
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
     * Set meta_numerisateur_id
     *
     * @param integer $metaNumerisateurId
     * @return ObservationView
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
     * Set numerisateur
     *
     * @param string $numerisateur
     * @return ObservationView
     */
    public function setNumerisateur($numerisateur)
    {
        $this->numerisateur = $numerisateur;

        return $this;
    }

    /**
     * Get numerisateur
     *
     * @return string 
     */
    public function getNumerisateur()
    {
        return $this->numerisateur;
    }

    /**
     * Set bv_commentaire
     *
     * @param string $bvCommentaire
     * @return ObservationView
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
     * @return ObservationView
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
     * Set cvc_temperature
     *
     * @param float $cvcTemperature
     * @return ObservationView
     */
    public function setCvcTemperature($cvcTemperature)
    {
        $this->cvc_temperature = $cvcTemperature;

        return $this;
    }

    /**
     * Get cvc_temperature
     *
     * @return float 
     */
    public function getCvcTemperature()
    {
        return $this->cvc_temperature;
    }

    /**
     * Set cvc_humidite
     *
     * @param float $cvcHumidite
     * @return ObservationView
     */
    public function setCvcHumidite($cvcHumidite)
    {
        $this->cvc_humidite = $cvcHumidite;

        return $this;
    }

    /**
     * Get cvc_humidite
     *
     * @return float 
     */
    public function getCvcHumidite()
    {
        return $this->cvc_humidite;
    }

    /**
     * Set nb_taxons
     *
     * @param integer $nbTaxons
     * @return ObservationView
     */
    public function setNbTaxons($nbTaxons)
    {
        $this->nb_taxons = $nbTaxons;

        return $this;
    }

    /**
     * Get nb_taxons
     *
     * @return integer 
     */
    public function getNbTaxons()
    {
        return $this->nb_taxons;
    }

    /**
     * Set abondance
     *
     * @param integer $abondance
     * @return ObservationView
     */
    public function setAbondance($abondance)
    {
        $this->abondance = $abondance;

        return $this;
    }

    /**
     * Get abondance
     *
     * @return integer 
     */
    public function getAbondance()
    {
        return $this->abondance;
    }

    /**
     * Set cvc_mod_id
     *
     * @param integer $cvcModId
     * @return ObservationView
     */
    public function setCvcModId($cvcModId)
    {
        $this->cvc_mod_id = $cvcModId;

        return $this;
    }

    /**
     * Get cvc_mod_id
     *
     * @return integer 
     */
    public function getCvcModId()
    {
        return $this->cvc_mod_id;
    }

    /**
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return ObservationView
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
     * @return ObservationView
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
     * Set ref_commune
     *
     * @param array $refCommune
     * @return ObservationView
     */
    public function setRefCommune($refCommune)
    {
        $this->ref_commune = $refCommune;

        return $this;
    }

    /**
     * Get ref_commune
     *
     * @return array 
     */
    public function getRefCommune()
    {
        return $this->ref_commune;
    }

    /**
     * Add observateurs
     *
     * @param \PNC\ChiroBundle\Entity\ObservateurView $observateurs
     * @return ObservationView
     */
    public function addObservateur(\PNC\ChiroBundle\Entity\ObservateurView $observateurs)
    {
        $this->observateurs[] = $observateurs;

        return $this;
    }

    /**
     * Remove observateurs
     *
     * @param \PNC\ChiroBundle\Entity\ObservateurView $observateurs
     */
    public function removeObservateur(\PNC\ChiroBundle\Entity\ObservateurView $observateurs)
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
