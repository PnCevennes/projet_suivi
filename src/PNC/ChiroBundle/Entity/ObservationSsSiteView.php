<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservationSsSiteView
 */
class ObservationSsSiteView
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $geom;

    /**
     * @var \DateTime
     */
    private $obs_date;

    /**
     * @var integer
     */
    private $numerisateur_id;

    /**
     * @var string
     */
    private $numerisateur;

    /**
     * @var string
     */
    private $obs_commentaire;

    /**
     * @var integer
     */
    private $obs_id_table_src;

    /**
     * @var float
     */
    private $obs_temperature;

    /**
     * @var float
     */
    private $obs_humidite;

    /**
     * @var integer
     */
    private $nb_taxons;

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
     * @return ObservationSsSiteView
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
     * Set geom
     *
     * @param array $geom
     * @return ObservationSsSiteView
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
     * Set obs_date
     *
     * @param \DateTime $obsDate
     * @return ObservationSsSiteView
     */
    public function setObsDate($obsDate)
    {
        $this->obs_date = $obsDate;

        return $this;
    }

    /**
     * Get obs_date
     *
     * @return \DateTime 
     */
    public function getObsDate()
    {
        return $this->obs_date;
    }

    /**
     * Set numerisateur_id
     *
     * @param integer $numerisateurId
     * @return ObservationSsSiteView
     */
    public function setNumerisateurId($numerisateurId)
    {
        $this->numerisateur_id = $numerisateurId;

        return $this;
    }

    /**
     * Get numerisateur_id
     *
     * @return integer 
     */
    public function getNumerisateurId()
    {
        return $this->numerisateur_id;
    }

    /**
     * Set numerisateur
     *
     * @param string $numerisateur
     * @return ObservationSsSiteView
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
     * Set obs_commentaire
     *
     * @param string $obsCommentaire
     * @return ObservationSsSiteView
     */
    public function setObsCommentaire($obsCommentaire)
    {
        $this->obs_commentaire = $obsCommentaire;

        return $this;
    }

    /**
     * Get obs_commentaire
     *
     * @return string 
     */
    public function getObsCommentaire()
    {
        return $this->obs_commentaire;
    }

    /**
     * Set obs_id_table_src
     *
     * @param integer $obsIdTableSrc
     * @return ObservationSsSiteView
     */
    public function setObsIdTableSrc($obsIdTableSrc)
    {
        $this->obs_id_table_src = $obsIdTableSrc;

        return $this;
    }

    /**
     * Get obs_id_table_src
     *
     * @return integer 
     */
    public function getObsIdTableSrc()
    {
        return $this->obs_id_table_src;
    }

    /**
     * Set obs_temperature
     *
     * @param float $obsTemperature
     * @return ObservationSsSiteView
     */
    public function setObsTemperature($obsTemperature)
    {
        $this->obs_temperature = $obsTemperature;

        return $this;
    }

    /**
     * Get obs_temperature
     *
     * @return float 
     */
    public function getObsTemperature()
    {
        return $this->obs_temperature;
    }

    /**
     * Set obs_humidite
     *
     * @param float $obsHumidite
     * @return ObservationSsSiteView
     */
    public function setObsHumidite($obsHumidite)
    {
        $this->obs_humidite = $obsHumidite;

        return $this;
    }

    /**
     * Get obs_humidite
     *
     * @return float 
     */
    public function getObsHumidite()
    {
        return $this->obs_humidite;
    }

    /**
     * Set nb_taxons
     *
     * @param integer $nbTaxons
     * @return ObservationSsSiteView
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
     * Add observateurs
     *
     * @param \PNC\ChiroBundle\Entity\ObservateurView $observateurs
     * @return ObservationSsSiteView
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
