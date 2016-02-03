<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * ObservationTaxon
 */
class ObservationTaxon extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fk_bv_id;

    /**
     * @var string
     */
    private $cotx_tx_initial;

    /**
     * @var boolean
     */
    private $cotx_espece_incertaine;

    /**
     * @var integer
     */
    private $cotx_effectif_abs;

    /**
     * @var integer
     */
    private $cotx_nb_male_adulte;

    /**
     * @var integer
     */
    private $cotx_nb_femelle_adulte;

    /**
     * @var integer
     */
    private $cotx_nb_male_juvenile;

    /**
     * @var integer
     */
    private $cotx_nb_femelle_juvenile;

    /**
     * @var integer
     */
    private $cotx_nb_male_indetermine;

    /**
     * @var integer
     */
    private $cotx_nb_femelle_indetermine;

    /**
     * @var integer
     */
    private $cotx_nb_indetermine_adulte;

    /**
     * @var integer
     */
    private $cotx_nb_indetermine_juvenile;

    /**
     * @var integer
     */
    private $cotx_nb_indetermine_indetermine;

    /**
     * @var integer
     */
    private $cotx_obj_status_validation;

    /**
     * @var string
     */
    private $cotx_commentaire;

    /**
     * @var integer
     */
    private $cotx_cd_nom;

    /**
     * @var string
     */
    private $cotx_nom_complet;

    /**
     * @var integer
     */
    private $cotx_validateur;

    /**
     * @var integer
     */
    private $cotx_act_id;

    /**
     * @var integer
     */
    private $cotx_eff_id;

    /**
     * @var integer
     */
    private $cotx_prv_id;

    /**
     * @var integer
     */
    private $cotx_num_id;

    /**
     * @var \DateTime
     */
    private $cotx_date_validation;

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
     * Set fk_bv_id
     *
     * @param integer $fkBvId
     * @return ObservationTaxon
     */
    public function setFkBvId($fkBvId)
    {
        $this->fk_bv_id = $fkBvId;

        return $this;
    }

    /**
     * Get fk_bv_id
     *
     * @return integer 
     */
    public function getFkBvId()
    {
        return $this->fk_bv_id;
    }

    /**
     * Set cotx_initial
     *
     * @param string $cotxInitial
     * @return ObservationTaxon
     */
    public function setCotxTxInitial($cotxInitial)
    {
        $this->cotx_tx_initial = $cotxInitial;

        return $this;
    }

    /**
     * Get cotx_initial
     *
     * @return string 
     */
    public function getCotxTxInitial()
    {
        return $this->cotx_tx_initial;
    }

    /**
     * Set cotx_espece_incertaine
     *
     * @param boolean $cotxEspeceIncertaine
     * @return ObservationTaxon
     */
    public function setCotxEspeceIncertaine($cotxEspeceIncertaine)
    {
        $this->cotx_espece_incertaine = $cotxEspeceIncertaine;

        return $this;
    }

    /**
     * Get cotx_espece_incertaine
     *
     * @return boolean 
     */
    public function getCotxEspeceIncertaine()
    {
        return $this->cotx_espece_incertaine;
    }

    /**
     * Set cotx_effectif_abs
     *
     * @param integer $cotxEffectifAbs
     * @return ObservationTaxon
     */
    public function setCotxEffectifAbs($cotxEffectifAbs)
    {
        if($cotxEffectifAbs < 1){
            $this->add_error('cotxEffectifAbs', "L'effectif total doit être supérieur à 0");
        }
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
     * Set cotx_nb_male_adulte
     *
     * @param integer $cotxNbMaleAdulte
     * @return ObservationTaxon
     */
    public function setCotxNbMaleAdulte($cotxNbMaleAdulte)
    {
        $this->cotx_nb_male_adulte = $cotxNbMaleAdulte;

        return $this;
    }

    /**
     * Get cotx_nb_male_adulte
     *
     * @return integer 
     */
    public function getCotxNbMaleAdulte()
    {
        return $this->cotx_nb_male_adulte;
    }

    /**
     * Set cotx_nb_femelle_adulte
     *
     * @param integer $cotxNbFemelleAdulte
     * @return ObservationTaxon
     */
    public function setCotxNbFemelleAdulte($cotxNbFemelleAdulte)
    {
        $this->cotx_nb_femelle_adulte = $cotxNbFemelleAdulte;

        return $this;
    }

    /**
     * Get cotx_nb_femelle_adulte
     *
     * @return integer 
     */
    public function getCotxNbFemelleAdulte()
    {
        return $this->cotx_nb_femelle_adulte;
    }

    /**
     * Set cotx_nb_male_juvenile
     *
     * @param integer $cotxNbMaleJuvenile
     * @return ObservationTaxon
     */
    public function setCotxNbMaleJuvenile($cotxNbMaleJuvenile)
    {
        $this->cotx_nb_male_juvenile = $cotxNbMaleJuvenile;

        return $this;
    }

    /**
     * Get cotx_nb_male_juvenile
     *
     * @return integer 
     */
    public function getCotxNbMaleJuvenile()
    {
        return $this->cotx_nb_male_juvenile;
    }

    /**
     * Set cotx_nb_femelle_juvenile
     *
     * @param integer $cotxNbFemelleJuvenile
     * @return ObservationTaxon
     */
    public function setCotxNbFemelleJuvenile($cotxNbFemelleJuvenile)
    {
        $this->cotx_nb_femelle_juvenile = $cotxNbFemelleJuvenile;

        return $this;
    }

    /**
     * Get cotx_nb_femelle_juvenile
     *
     * @return integer 
     */
    public function getCotxNbFemelleJuvenile()
    {
        return $this->cotx_nb_femelle_juvenile;
    }

    /**
     * Set cotx_nb_male_indetermine
     *
     * @param integer $cotxNbMaleIndetermine
     * @return ObservationTaxon
     */
    public function setCotxNbMaleIndetermine($cotxNbMaleIndetermine)
    {
        $this->cotx_nb_male_indetermine = $cotxNbMaleIndetermine;

        return $this;
    }

    /**
     * Get cotx_nb_male_indetermine
     *
     * @return integer 
     */
    public function getCotxNbMaleIndetermine()
    {
        return $this->cotx_nb_male_indetermine;
    }

    /**
     * Set cotx_nb_femelle_indetermine
     *
     * @param integer $cotxNbFemelleIndetermine
     * @return ObservationTaxon
     */
    public function setCotxNbFemelleIndetermine($cotxNbFemelleIndetermine)
    {
        $this->cotx_nb_femelle_indetermine = $cotxNbFemelleIndetermine;

        return $this;
    }

    /**
     * Get cotx_nb_femelle_indetermine
     *
     * @return integer 
     */
    public function getCotxNbFemelleIndetermine()
    {
        return $this->cotx_nb_femelle_indetermine;
    }

    /**
     * Set cotx_nb_indetermine_adulte
     *
     * @param integer $cotxNbIndetermineAdulte
     * @return ObservationTaxon
     */
    public function setCotxNbIndetermineAdulte($cotxNbIndetermineAdulte)
    {
        $this->cotx_nb_indetermine_adulte = $cotxNbIndetermineAdulte;

        return $this;
    }

    /**
     * Get cotx_nb_indetermine_adulte
     *
     * @return integer 
     */
    public function getCotxNbIndetermineAdulte()
    {
        return $this->cotx_nb_indetermine_adulte;
    }

    /**
     * Set cotx_nb_indetermine_juvenile
     *
     * @param integer $cotxNbIndetermineJuvenile
     * @return ObservationTaxon
     */
    public function setCotxNbIndetermineJuvenile($cotxNbIndetermineJuvenile)
    {
        $this->cotx_nb_indetermine_juvenile = $cotxNbIndetermineJuvenile;

        return $this;
    }

    /**
     * Get cotx_nb_indetermine_juvenile
     *
     * @return integer 
     */
    public function getCotxNbIndetermineJuvenile()
    {
        return $this->cotx_nb_indetermine_juvenile;
    }

    /**
     * Set cotx_nb_indetermine_indetermine
     *
     * @param integer $cotxNbIndetermineIndetermine
     * @return ObservationTaxon
     */
    public function setCotxNbIndetermineIndetermine($cotxNbIndetermineIndetermine)
    {
        $this->cotx_nb_indetermine_indetermine = $cotxNbIndetermineIndetermine;

        return $this;
    }

    /**
     * Get cotx_nb_indetermine_indetermine
     *
     * @return integer 
     */
    public function getCotxNbIndetermineIndetermine()
    {
        return $this->cotx_nb_indetermine_indetermine;
    }

    /**
     * Set cotx_obj_status_validation
     *
     * @param integer $cotxObjStatusValidation
     * @return ObservationTaxon
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
     * Set cotx_commentaire
     *
     * @param string $cotxCommentaire
     * @return ObservationTaxon
     */
    public function setCotxCommentaire($cotxCommentaire)
    {
        $this->cotx_commentaire = $cotxCommentaire;

        return $this;
    }

    /**
     * Get cotx_commentaire
     *
     * @return string 
     */
    public function getCotxCommentaire()
    {
        return $this->cotx_commentaire;
    }

    /**
     * Set cd_nom
     *
     * @param integer $cdNom
     * @return ObservationTaxon
     */
    public function setCotxCdNom($cdNom)
    {
        $this->cotx_cd_nom = $cdNom;

        return $this;
    }

    /**
     * Get cd_nom
     *
     * @return integer 
     */
    public function getCotxCdNom()
    {
        return $this->cotx_cd_nom;
    }

    /**
     * Set nom_complet
     *
     * @param string $nomComplet
     * @return ObservationTaxon
     */
    public function setCotxNomComplet($nomComplet)
    {
        $this->cotx_nom_complet = $nomComplet;

        return $this;
    }

    /**
     * Get nom_complet
     *
     * @return string 
     */
    public function getCotxNomComplet()
    {
        return $this->cotx_nom_complet;
    }

    /**
     * Set cotx_validateur
     *
     * @param integer $cotxValidateur
     * @return ObservationTaxon
     */
    public function setCotxValidateur($cotxValidateur)
    {
        $this->cotx_validateur = $cotxValidateur;

        return $this;
    }

    /**
     * Get cotx_validateur
     *
     * @return integer 
     */
    public function getCotxValidateur()
    {
        return $this->cotx_validateur;
    }

    /**
     * Set cotx_act_id
     *
     * @param integer $cotxActId
     * @return ObservationTaxon
     */
    public function setCotxActId($cotxActId)
    {
        $this->cotx_act_id = $cotxActId;

        return $this;
    }

    /**
     * Get cotx_act_id
     *
     * @return integer 
     */
    public function getCotxActId()
    {
        return $this->cotx_act_id;
    }

    /**
     * Set cotx_eff_id
     *
     * @param integer $cotxEffId
     * @return ObservationTaxon
     */
    public function setCotxEffId($cotxEffId)
    {
        $this->cotx_eff_id = $cotxEffId;

        return $this;
    }

    /**
     * Get cotx_eff_id
     *
     * @return integer 
     */
    public function getCotxEffId()
    {
        return $this->cotx_eff_id;
    }

    /**
     * Set cotx_prv_id
     *
     * @param integer $cotxPrvId
     * @return ObservationTaxon
     */
    public function setCotxPrvId($cotxPrvId)
    {
        $this->cotx_prv_id = $cotxPrvId;

        return $this;
    }

    /**
     * Get cotx_prv_id
     *
     * @return integer 
     */
    public function getCotxPrvId()
    {
        return $this->cotx_prv_id;
    }

    /**
     * Set cotx_num_id
     *
     * @param integer $cotxNumId
     * @return ObservationTaxon
     */
    public function setCotxNumId($cotxNumId)
    {
        $this->cotx_num_id = $cotxNumId;

        return $this;
    }

    /**
     * Get cotx_num_id
     *
     * @return integer 
     */
    public function getCotxNumId()
    {
        return $this->cotx_num_id;
    }

    /**
     * Set cotx_date_validation
     *
     * @param \DateTime $cotxDateValidation
     * @return ObservationTaxon
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
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return ObservationTaxon
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
     * @return ObservationTaxon
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
     * @return ObservationTaxon
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
     * @var integer
     */
    private $cotx_mod_id;


    /**
     * Set cotx_mod_id
     *
     * @param integer $cotxModId
     * @return ObservationTaxon
     */
    public function setCotxModId($cotxModId)
    {
        $this->cotx_mod_id = $cotxModId;

        return $this;
    }

    /**
     * Get cotx_mod_id
     *
     * @return integer 
     */
    public function getCotxModId()
    {
        return $this->cotx_mod_id;
    }
}
