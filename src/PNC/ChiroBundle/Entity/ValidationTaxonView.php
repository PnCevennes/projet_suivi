<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ValidationTaxonView
 */
class ValidationTaxonView
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cd_nom;

    /**
     * @var string
     */
    private $nom_complet;

    /**
     * @var integer
     */
    private $obs_effectif_abs;

    /**
     * @var \DateTime
     */
    private $obs_date;

    /**
     * @var string
     */
    private $site_nom;

    /**
     * @var array
     */
    private $geom;


    private $obs_obj_status_validation;

    public function getObsObjStatusValidation(){
        return $this->obs_obj_status_validation;
    }

    public function setObsObjStatusValidation($v){
        $this->obs_obj_status_validation = $v;
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
     * Set cd_nom
     *
     * @param integer $cdNom
     * @return ValidationTaxonView
     */
    public function setCdNom($cdNom)
    {
        $this->cd_nom = $cdNom;

        return $this;
    }

    /**
     * Get cd_nom
     *
     * @return integer 
     */
    public function getCdNom()
    {
        return $this->cd_nom;
    }

    /**
     * Set nom_complet
     *
     * @param string $nomComplet
     * @return ValidationTaxonView
     */
    public function setNomComplet($nomComplet)
    {
        $this->nom_complet = $nomComplet;

        return $this;
    }

    /**
     * Get nom_complet
     *
     * @return string 
     */
    public function getNomComplet()
    {
        return $this->nom_complet;
    }

    /**
     * Set obs_effectif_abs
     *
     * @param integer $obsEffectifAbs
     * @return ValidationTaxonView
     */
    public function setObsEffectifAbs($obsEffectifAbs)
    {
        $this->obs_effectif_abs = $obsEffectifAbs;

        return $this;
    }

    /**
     * Get obs_effectif_abs
     *
     * @return integer 
     */
    public function getObsEffectifAbs()
    {
        return $this->obs_effectif_abs;
    }

    /**
     * Set obs_date
     *
     * @param \DateTime $obsDate
     * @return ValidationTaxonView
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
     * Set site_nom
     *
     * @param string $siteNom
     * @return ValidationTaxonView
     */
    public function setSiteNom($siteNom)
    {
        $this->site_nom = $siteNom;

        return $this;
    }

    /**
     * Get site_nom
     *
     * @return string 
     */
    public function getSiteNom()
    {
        return $this->site_nom;
    }

    /**
     * Set geom
     *
     * @param array $geom
     * @return ValidationTaxonView
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
     * @var \DateTime
     */
    private $date_validation;

    /**
     * @var string
     */
    private $validateur;

    /**
     * @var string
     */
    private $numerisateur;


    /**
     * Set date_validation
     *
     * @param \DateTime $dateValidation
     * @return ValidationTaxonView
     */
    public function setDateValidation($dateValidation)
    {
        $this->date_validation = $dateValidation;

        return $this;
    }

    /**
     * Get date_validation
     *
     * @return \DateTime 
     */
    public function getDateValidation()
    {
        return $this->date_validation;
    }

    /**
     * Set validateur
     *
     * @param string $validateur
     * @return ValidationTaxonView
     */
    public function setValidateur($validateur)
    {
        $this->validateur = $validateur;

        return $this;
    }

    /**
     * Get validateur
     *
     * @return string 
     */
    public function getValidateur()
    {
        return $this->validateur;
    }

    /**
     * Set numerisateur
     *
     * @param string $numerisateur
     * @return ValidationTaxonView
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
     * @var array
     */
    private $observateurs;


    /**
     * Set observateurs
     *
     * @param array $observateurs
     * @return ValidationTaxonView
     */
    public function setObservateurs($observateurs)
    {
        $this->observateurs = $observateurs;

        return $this;
    }

    /**
     * Get observateurs
     *
     * @return array 
     */
    public function getObservateurs()
    {
        return $this->observateurs;
    }
}
