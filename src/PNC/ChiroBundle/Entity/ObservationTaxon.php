<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservationTaxon
 */
class ObservationTaxon
{

    private $_errors = array();

    /*
     * Retourne la liste des champs invalides s'il y en a
     * ou false si tout est OK
     */

    public function errors(){
        /*if(empty($this->_errors)){
            return false;
        }*/
        return $this->_errors;
    }

    /**
     * @var integer
     */
    private $rt_id;

    /**
     * @var string
     */
    private $obs_tx_initial;

    /**
     * @var boolean
     */
    private $obs_espece_incertaine;

    /**
     * @var integer
     */
    private $obs_effectif_abs;

    /**
     * @var integer
     */
    private $obs_nb_male_adulte;

    /**
     * @var integer
     */
    private $obs_nb_femelle_adulte;

    /**
     * @var integer
     */
    private $obs_nb_male_juvenile;

    /**
     * @var integer
     */
    private $obs_nb_femelle_juvenile;

    /**
     * @var integer
     */
    private $obs_nb_male_indetermine;

    /**
     * @var integer
     */
    private $obs_nb_femelle_indetermine;

    /**
     * @var integer
     */
    private $obs_nb_indetermine_indetermine;

    /**
     * @var integer
     */
    private $obs_obj_status_validation;

    /**
     * @var string
     */
    private $obs_commentaire;

    /**
     * @var integer
     */
    private $obs_validateur;

    private $act_id;

    private $eff_id;

    private $prv_id;

    private $num_id;

    public function getNumId(){
        return $this->num_id;
    }

    public function setNumId($num_id){
        $this->num_id = $num_id;
        return $this;
    }

    public function getActId(){
        return $this->act_id;
    }

    public function setActId($act_id){
        $this->act_id = $act_id;
        return $this;
    }

    public function getEffId(){
        return $this->eff_id;
    }

    public function setEffId($eff_id){
        $this->eff_id = $eff_id;
        return $this;
    }

    public function getPrvId(){
        return $this->prv_id;
    }

    public function setPrvId($prv_id){
        $this->prv_id = $prv_id;
        return $this;
    }


    /**
     * Get rt_id
     *
     * @return integer 
     */
    public function getRtId()
    {
        return $this->rt_id;
    }

    /**
     * Set obs_tx_initial
     *
     * @param string $obsTxInitial
     * @return ObservationTaxon
     */
    public function setObsTxInitial($obsTxInitial)
    {
        $this->obs_tx_initial = $obsTxInitial;

        return $this;
    }

    /**
     * Get obs_tx_initial
     *
     * @return string 
     */
    public function getObsTxInitial()
    {
        return $this->obs_tx_initial;
    }

    /**
     * Set obs_espece_incertaine
     *
     * @param boolean $obsEspeceIncertaine
     * @return ObservationTaxon
     */
    public function setObsEspeceIncertaine($obsEspeceIncertaine)
    {
        $this->obs_espece_incertaine = $obsEspeceIncertaine;

        return $this;
    }

    /**
     * Get obs_espece_incertaine
     *
     * @return boolean 
     */
    public function getObsEspeceIncertaine()
    {
        return $this->obs_espece_incertaine;
    }

    /**
     * Set obs_effectif_abs
     *
     * @param integer $obsEffectifAbs
     * @return ObservationTaxon
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
     * Set obs_nb_male_adulte
     *
     * @param integer $obsNbMaleAdulte
     * @return ObservationTaxon
     */
    public function setObsNbMaleAdulte($obsNbMaleAdulte)
    {
        $this->obs_nb_male_adulte = $obsNbMaleAdulte;

        return $this;
    }

    /**
     * Get obs_nb_male_adulte
     *
     * @return integer 
     */
    public function getObsNbMaleAdulte()
    {
        return $this->obs_nb_male_adulte;
    }

    /**
     * Set obs_nb_femelle_adulte
     *
     * @param integer $obsNbFemelleAdulte
     * @return ObservationTaxon
     */
    public function setObsNbFemelleAdulte($obsNbFemelleAdulte)
    {
        $this->obs_nb_femelle_adulte = $obsNbFemelleAdulte;

        return $this;
    }

    /**
     * Get obs_nb_femelle_adulte
     *
     * @return integer 
     */
    public function getObsNbFemelleAdulte()
    {
        return $this->obs_nb_femelle_adulte;
    }

    /**
     * Set obs_nb_male_juvenile
     *
     * @param integer $obsNbMaleJuvenile
     * @return ObservationTaxon
     */
    public function setObsNbMaleJuvenile($obsNbMaleJuvenile)
    {
        $this->obs_nb_male_juvenile = $obsNbMaleJuvenile;

        return $this;
    }

    /**
     * Get obs_nb_male_juvenile
     *
     * @return integer 
     */
    public function getObsNbMaleJuvenile()
    {
        return $this->obs_nb_male_juvenile;
    }

    /**
     * Set obs_nb_femelle_juvenile
     *
     * @param integer $obsNbFemelleJuvenile
     * @return ObservationTaxon
     */
    public function setObsNbFemelleJuvenile($obsNbFemelleJuvenile)
    {
        $this->obs_nb_femelle_juvenile = $obsNbFemelleJuvenile;

        return $this;
    }

    /**
     * Get obs_nb_femelle_juvenile
     *
     * @return integer 
     */
    public function getObsNbFemelleJuvenile()
    {
        return $this->obs_nb_femelle_juvenile;
    }

    /**
     * Set obs_nb_male_indetermine
     *
     * @param integer $obsNbMaleIndetermine
     * @return ObservationTaxon
     */
    public function setObsNbMaleIndetermine($obsNbMaleIndetermine)
    {
        $this->obs_nb_male_indetermine = $obsNbMaleIndetermine;

        return $this;
    }

    /**
     * Get obs_nb_male_indetermine
     *
     * @return integer 
     */
    public function getObsNbMaleIndetermine()
    {
        return $this->obs_nb_male_indetermine;
    }

    /**
     * Set obs_nb_femelle_indetermine
     *
     * @param integer $obsNbFemelleIndetermine
     * @return ObservationTaxon
     */
    public function setObsNbFemelleIndetermine($obsNbFemelleIndetermine)
    {
        $this->obs_nb_femelle_indetermine = $obsNbFemelleIndetermine;

        return $this;
    }

    /**
     * Get obs_nb_femelle_indetermine
     *
     * @return integer 
     */
    public function getObsNbFemelleIndetermine()
    {
        return $this->obs_nb_femelle_indetermine;
    }

    /**
     * Set obs_nb_indetermine_indetermine
     *
     * @param integer $obsNbIndetermineIndetermine
     * @return ObservationTaxon
     */
    public function setObsNbIndetermineIndetermine($obsNbIndetermineIndetermine)
    {
        $this->obs_nb_indetermine_indetermine = $obsNbIndetermineIndetermine;

        return $this;
    }

    /**
     * Get obs_nb_indetermine_indetermine
     *
     * @return integer 
     */
    public function getObsNbIndetermineIndetermine()
    {
        return $this->obs_nb_indetermine_indetermine;
    }

    /**
     * Set obs_obj_status_validation
     *
     * @param integer $obsObjStatusValidation
     * @return ObservationTaxon
     */
    public function setObsObjStatusValidation($obsObjStatusValidation)
    {
        $this->obs_obj_status_validation = $obsObjStatusValidation;

        return $this;
    }

    /**
     * Get obs_obj_status_validation
     *
     * @return integer 
     */
    public function getObsObjStatusValidation()
    {
        return $this->obs_obj_status_validation;
    }

    /**
     * Set obs_commentaire
     *
     * @param string $obsCommentaire
     * @return ObservationTaxon
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
     * @var integer
     */
    private $ot_id;


    /**
     * Get ot_id
     *
     * @return integer 
     */
    public function getOtId()
    {
        return $this->ot_id;
    }
    /**
     * @var integer
     */
    private $id;


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
     * @var integer
     */
    private $obs_id;

    /**
     * @var \PNC\BaseAppBundle\Entity\Observation
     */
    private $observation;


    /**
     * Set obs_id
     *
     * @param integer $obsId
     * @return ObservationTaxon
     */
    public function setObsId($obsId)
    {
        $this->obs_id = $obsId;

        return $this;
    }

    /**
     * Get obs_id
     *
     * @return integer 
     */
    public function getObsId()
    {
        return $this->obs_id;
    }

    /**
     * Set observation
     *
     * @param \PNC\BaseAppBundle\Entity\Observation $observation
     * @return ObservationTaxon
     */
    public function setObservation(\PNC\BaseAppBundle\Entity\Observation $observation = null)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \PNC\BaseAppBundle\Entity\Observation 
     */
    public function getObservation()
    {
        return $this->observation;
    }
    /**
     * @var integer
     */
    private $cd_nom;

    /**
     * @var string
     */
    private $nom_complet;


    /**
     * Set cd_nom
     *
     * @param integer $cdNom
     * @return ObservationTaxon
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
     * @return ObservationTaxon
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

    public function setObsValidateur($validateur){
        $this->obs_validateur = $validateur;
        return $this;
    }

    public function getObsValidateur(){
        return $this->obs_validateur;
    }
    /**
     * @var \DateTime
     */
    private $date_validation;


    /**
     * Set date_validation
     *
     * @param \DateTime $dateValidation
     * @return ObservationTaxon
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
}
