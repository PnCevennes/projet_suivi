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
    private $site_id;

    /**
     * @var \DateTime
     */
    private $obs_date;

    /**
     * @var string
     */
    private $obs_commentaire;

    /**
     * @var integer
     */
    private $obs_id_table_src;

    /**
     * @var string
     */
    private $obs_temperature;

    /**
     * @var string
     */
    private $obs_humidite;

    /**
     * @var integer
     */
    private $nb_taxons;


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
     * Set site_id
     *
     * @param integer $siteId
     * @return ObservationView
     */
    public function setSiteId($siteId)
    {
        $this->site_id = $siteId;

        return $this;
    }

    /**
     * Get site_id
     *
     * @return integer 
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * Set obs_date
     *
     * @param \DateTime $obsDate
     * @return ObservationView
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
     * Set obs_commentaire
     *
     * @param string $obsCommentaire
     * @return ObservationView
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
     * @return ObservationView
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
     * @param string $obsTemperature
     * @return ObservationView
     */
    public function setObsTemperature($obsTemperature)
    {
        $this->obs_temperature = $obsTemperature;

        return $this;
    }

    /**
     * Get obs_temperature
     *
     * @return string 
     */
    public function getObsTemperature()
    {
        return $this->obs_temperature;
    }

    /**
     * Set obs_humidite
     *
     * @param string $obsHumidite
     * @return ObservationView
     */
    public function setObsHumidite($obsHumidite)
    {
        $this->obs_humidite = $obsHumidite;

        return $this;
    }

    /**
     * Get obs_humidite
     *
     * @return string 
     */
    public function getObsHumidite()
    {
        return $this->obs_humidite;
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
