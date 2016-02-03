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
    private $cotx_effectif_abs;

    /**
     * @var \DateTime
     */
    private $bv_date;

    /**
     * @var integer
     */
    private $cotx_obj_status_validation;

    /**
     * @var \DateTime
     */
    private $cotx_date_validation;

    /**
     * @var string
     */
    private $cotx_validateur;

    /**
     * @var string
     */
    private $meta_numerisateur_id;

    /**
     * @var array
     */
    private $observateurs;

    /**
     * @var string
     */
    private $bs_nom;

    /**
     * @var array
     */
    private $geom;

    private $meta_create_timestamp;

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
     * Set cotx_effectif_abs
     *
     * @param integer $cotxEffectifAbs
     * @return ValidationTaxonView
     */
    public function setCotxEffectifAbs($cotxEffectifAbs)
    {
        $this->cotx_effectif_abs = $cotxEffectifAbs;

        return $this;
    }

    /**
     * Get cotx_effectif_abs
     *
     * @return integer 
     */
    public function getCotxEffectifAbs()
    {
        return $this->cotx_effectif_abs;
    }

    /**
     * Set bv_date
     *
     * @param \DateTime $bvDate
     * @return ValidationTaxonView
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
     * Set cotx_obj_status_validation
     *
     * @param integer $cotxObjStatusValidation
     * @return ValidationTaxonView
     */
    public function setCotxObjStatusValidation($cotxObjStatusValidation)
    {
        $this->cotx_obj_status_validation = $cotxObjStatusValidation;

        return $this;
    }

    /**
     * Get cotx_obj_status_validation
     *
     * @return integer 
     */
    public function getCotxObjStatusValidation()
    {
        return $this->cotx_obj_status_validation;
    }

    /**
     * Set cotx_date_validation
     *
     * @param \DateTime $cotxDateValidation
     * @return ValidationTaxonView
     */
    public function setCotxDateValidation($cotxDateValidation)
    {
        $this->cotx_date_validation = $cotxDateValidation;

        return $this;
    }

    /**
     * Get cotx_date_validation
     *
     * @return \DateTime 
     */
    public function getCotxDateValidation()
    {
        return $this->cotx_date_validation;
    }

    /**
     * Set cotx_validateur
     *
     * @param string $cotxValidateur
     * @return ValidationTaxonView
     */
    public function setCotxValidateur($cotxValidateur)
    {
        $this->cotx_validateur = $cotxValidateur;

        return $this;
    }

    /**
     * Get cotx_validateur
     *
     * @return string 
     */
    public function getCotxValidateur()
    {
        return $this->cotx_validateur;
    }

    /**
     * Set meta_numerisateur_id
     *
     * @param string $metaNumerisateurId
     * @return ValidationTaxonView
     */
    public function setMetaNumerisateurId($metaNumerisateurId)
    {
        $this->meta_numerisateur_id = $metaNumerisateurId;

        return $this;
    }

    /**
     * Get meta_numerisateur_id
     *
     * @return string 
     */
    public function getMetaNumerisateurId()
    {
        return $this->meta_numerisateur_id;
    }

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

    /**
     * Set bs_nom
     *
     * @param string $bsNom
     * @return ValidationTaxonView
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
     * @var string
     */
    private $validateur;


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
     * @var string
     */
    private $numerisateur;


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

    public function setMetaCreateTimestamp($ts){
        $this->meta_create_timestamp = $ts;
        return $this;
    }

    public function getMetaCreateTimestamp(){
        return $this->meta_create_timestamp;
    }
}
