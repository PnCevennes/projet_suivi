<?php

namespace PNC\PatrimoineBatiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfoSite
 */
class InfoSite
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
    private $pb_des_code_ref;

    /**
     * @var integer
     */
    private $pb_des_type_attribut_local;

    /**
     * @var string
     */
    private $pb_des_type_attribut_national;

    /**
     * @var string
     */
    private $pb_des_nom_synononymes;

    /**
     * @var string
     */
    private $pb_loc_lieudit;

    /**
     * @var integer
     */
    private $pb_loc_situation;

    /**
     * @var integer
     */
    private $pb_loc_orientation;

    /**
     * @var integer
     */
    private $pb_loc_visibilite;

    /**
     * @var integer
     */
    private $pb_loc_accessibilite;

    /**
     * @var integer
     */
    private $pb_loc_statut;

    /**
     * @var integer
     */
    private $pb_his_datation_type;

    /**
     * @var integer
     */
    private $pb_his_datation_periode;

    /**
     * @var string
     */
    private $pb_his_datation_exacte;

    /**
     * @var float
     */
    private $pb_des_dimensions_larg;

    /**
     * @var float
     */
    private $pb_des_dimensions_long;

    /**
     * @var float
     */
    private $pb_des_dimensions_haut;

    /**
     * @var float
     */
    private $pb_des_dimensions_e;

    /**
     * @var float
     */
    private $pb_des_dimensions_d;

    /**
     * @var string
     */
    private $pb_des_environnement_proche;

    /**
     * @var integer
     */
    private $pb_des_mur_misenoeuvre;

    /**
     * @var integer
     */
    private $pb_des_mur_revetement;

    /**
     * @var integer
     */
    private $pb_des_toit;

    /**
     * @var integer
     */
    private $pb_des_couvrement;

    /**
     * @var string
     */
    private $pb_des_complementaire;

    /**
     * @var integer
     */
    private $pb_des_etat;

    /**
     * @var integer
     */
    private $pb_interpretation;

    /**
     * @var string
     */
    private $pb_commentaire;

    /**
     * @var integer
     */
    private $pb_traitement_donnees;

    /**
     * @var integer
     */
    private $pb_source;

    /**
     * @var boolean
     */
    private $pb_dossiercandidature;

    /**
     * @var \PNC\BaseAppBundle\Entity\Site
     */
    private $parent_site;


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
     * @return InfoSite
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
     * Set pb_des_code_ref
     *
     * @param string $pbDesCodeRef
     * @return InfoSite
     */
    public function setPbDesCodeRef($pbDesCodeRef)
    {
        $this->pb_des_code_ref = $pbDesCodeRef;

        return $this;
    }

    /**
     * Get pb_des_code_ref
     *
     * @return string 
     */
    public function getPbDesCodeRef()
    {
        return $this->pb_des_code_ref;
    }

    /**
     * Set pb_des_type_attribut_local
     *
     * @param integer $pbDesTypeAttributLocal
     * @return InfoSite
     */
    public function setPbDesTypeAttributLocal($pbDesTypeAttributLocal)
    {
        $this->pb_des_type_attribut_local = $pbDesTypeAttributLocal;

        return $this;
    }

    /**
     * Get pb_des_type_attribut_local
     *
     * @return integer 
     */
    public function getPbDesTypeAttributLocal()
    {
        return $this->pb_des_type_attribut_local;
    }

    /**
     * Set pb_des_type_attribut_national
     *
     * @param string $pbDesTypeAttributNational
     * @return InfoSite
     */
    public function setPbDesTypeAttributNational($pbDesTypeAttributNational)
    {
        $this->pb_des_type_attribut_national = $pbDesTypeAttributNational;

        return $this;
    }

    /**
     * Get pb_des_type_attribut_national
     *
     * @return string 
     */
    public function getPbDesTypeAttributNational()
    {
        return $this->pb_des_type_attribut_national;
    }

    /**
     * Set pb_des_nom_synononymes
     *
     * @param string $pbDesNomSynononymes
     * @return InfoSite
     */
    public function setPbDesNomSynononymes($pbDesNomSynononymes)
    {
        $this->pb_des_nom_synononymes = $pbDesNomSynononymes;

        return $this;
    }

    /**
     * Get pb_des_nom_synononymes
     *
     * @return string 
     */
    public function getPbDesNomSynononymes()
    {
        return $this->pb_des_nom_synononymes;
    }

    /**
     * Set pb_loc_lieudit
     *
     * @param string $pbLocLieudit
     * @return InfoSite
     */
    public function setPbLocLieudit($pbLocLieudit)
    {
        $this->pb_loc_lieudit = $pbLocLieudit;

        return $this;
    }

    /**
     * Get pb_loc_lieudit
     *
     * @return string 
     */
    public function getPbLocLieudit()
    {
        return $this->pb_loc_lieudit;
    }

    /**
     * Set pb_loc_situation
     *
     * @param integer $pbLocSituation
     * @return InfoSite
     */
    public function setPbLocSituation($pbLocSituation)
    {
        $this->pb_loc_situation = $pbLocSituation;

        return $this;
    }

    /**
     * Get pb_loc_situation
     *
     * @return integer 
     */
    public function getPbLocSituation()
    {
        return $this->pb_loc_situation;
    }

    /**
     * Set pb_loc_orientation
     *
     * @param integer $pbLocOrientation
     * @return InfoSite
     */
    public function setPbLocOrientation($pbLocOrientation)
    {
        $this->pb_loc_orientation = $pbLocOrientation;

        return $this;
    }

    /**
     * Get pb_loc_orientation
     *
     * @return integer 
     */
    public function getPbLocOrientation()
    {
        return $this->pb_loc_orientation;
    }

    /**
     * Set pb_loc_visibilite
     *
     * @param integer $pbLocVisibilite
     * @return InfoSite
     */
    public function setPbLocVisibilite($pbLocVisibilite)
    {
        $this->pb_loc_visibilite = $pbLocVisibilite;

        return $this;
    }

    /**
     * Get pb_loc_visibilite
     *
     * @return integer 
     */
    public function getPbLocVisibilite()
    {
        return $this->pb_loc_visibilite;
    }

    /**
     * Set pb_loc_accessibilite
     *
     * @param integer $pbLocAccessibilite
     * @return InfoSite
     */
    public function setPbLocAccessibilite($pbLocAccessibilite)
    {
        $this->pb_loc_accessibilite = $pbLocAccessibilite;

        return $this;
    }

    /**
     * Get pb_loc_accessibilite
     *
     * @return integer 
     */
    public function getPbLocAccessibilite()
    {
        return $this->pb_loc_accessibilite;
    }

    /**
     * Set pb_loc_statut
     *
     * @param integer $pbLocStatut
     * @return InfoSite
     */
    public function setPbLocStatut($pbLocStatut)
    {
        $this->pb_loc_statut = $pbLocStatut;

        return $this;
    }

    /**
     * Get pb_loc_statut
     *
     * @return integer 
     */
    public function getPbLocStatut()
    {
        return $this->pb_loc_statut;
    }

    /**
     * Set pb_his_datation_type
     *
     * @param integer $pbHisDatationType
     * @return InfoSite
     */
    public function setPbHisDatationType($pbHisDatationType)
    {
        $this->pb_his_datation_type = $pbHisDatationType;

        return $this;
    }

    /**
     * Get pb_his_datation_type
     *
     * @return integer 
     */
    public function getPbHisDatationType()
    {
        return $this->pb_his_datation_type;
    }

    /**
     * Set pb_his_datation_periode
     *
     * @param integer $pbHisDatationPeriode
     * @return InfoSite
     */
    public function setPbHisDatationPeriode($pbHisDatationPeriode)
    {
        $this->pb_his_datation_periode = $pbHisDatationPeriode;

        return $this;
    }

    /**
     * Get pb_his_datation_periode
     *
     * @return integer 
     */
    public function getPbHisDatationPeriode()
    {
        return $this->pb_his_datation_periode;
    }

    /**
     * Set pb_his_datation_exacte
     *
     * @param string $pbHisDatationExacte
     * @return InfoSite
     */
    public function setPbHisDatationExacte($pbHisDatationExacte)
    {
        $this->pb_his_datation_exacte = $pbHisDatationExacte;

        return $this;
    }

    /**
     * Get pb_his_datation_exacte
     *
     * @return string 
     */
    public function getPbHisDatationExacte()
    {
        return $this->pb_his_datation_exacte;
    }

    /**
     * Set pb_des_dimensions_larg
     *
     * @param float $pbDesDimensionsLarg
     * @return InfoSite
     */
    public function setPbDesDimensionsLarg($pbDesDimensionsLarg)
    {
        $this->pb_des_dimensions_larg = $pbDesDimensionsLarg;

        return $this;
    }

    /**
     * Get pb_des_dimensions_larg
     *
     * @return float 
     */
    public function getPbDesDimensionsLarg()
    {
        return $this->pb_des_dimensions_larg;
    }

    /**
     * Set pb_des_dimensions_long
     *
     * @param float $pbDesDimensionsLong
     * @return InfoSite
     */
    public function setPbDesDimensionsLong($pbDesDimensionsLong)
    {
        $this->pb_des_dimensions_long = $pbDesDimensionsLong;

        return $this;
    }

    /**
     * Get pb_des_dimensions_long
     *
     * @return float 
     */
    public function getPbDesDimensionsLong()
    {
        return $this->pb_des_dimensions_long;
    }

    /**
     * Set pb_des_dimensions_haut
     *
     * @param float $pbDesDimensionsHaut
     * @return InfoSite
     */
    public function setPbDesDimensionsHaut($pbDesDimensionsHaut)
    {
        $this->pb_des_dimensions_haut = $pbDesDimensionsHaut;

        return $this;
    }

    /**
     * Get pb_des_dimensions_haut
     *
     * @return float 
     */
    public function getPbDesDimensionsHaut()
    {
        return $this->pb_des_dimensions_haut;
    }

    /**
     * Set pb_des_dimensions_e
     *
     * @param float $pbDesDimensionsE
     * @return InfoSite
     */
    public function setPbDesDimensionsE($pbDesDimensionsE)
    {
        $this->pb_des_dimensions_e = $pbDesDimensionsE;

        return $this;
    }

    /**
     * Get pb_des_dimensions_e
     *
     * @return float 
     */
    public function getPbDesDimensionsE()
    {
        return $this->pb_des_dimensions_e;
    }

    /**
     * Set pb_des_dimensions_d
     *
     * @param float $pbDesDimensionsD
     * @return InfoSite
     */
    public function setPbDesDimensionsD($pbDesDimensionsD)
    {
        $this->pb_des_dimensions_d = $pbDesDimensionsD;

        return $this;
    }

    /**
     * Get pb_des_dimensions_d
     *
     * @return float 
     */
    public function getPbDesDimensionsD()
    {
        return $this->pb_des_dimensions_d;
    }

    /**
     * Set pb_des_environnement_proche
     *
     * @param string $pbDesEnvironnementProche
     * @return InfoSite
     */
    public function setPbDesEnvironnementProche($pbDesEnvironnementProche)
    {
        $this->pb_des_environnement_proche = $pbDesEnvironnementProche;

        return $this;
    }

    /**
     * Get pb_des_environnement_proche
     *
     * @return string 
     */
    public function getPbDesEnvironnementProche()
    {
        return $this->pb_des_environnement_proche;
    }

    /**
     * Set pb_des_mur_misenoeuvre
     *
     * @param integer $pbDesMurMisenoeuvre
     * @return InfoSite
     */
    public function setPbDesMurMisenoeuvre($pbDesMurMisenoeuvre)
    {
        $this->pb_des_mur_misenoeuvre = $pbDesMurMisenoeuvre;

        return $this;
    }

    /**
     * Get pb_des_mur_misenoeuvre
     *
     * @return integer 
     */
    public function getPbDesMurMisenoeuvre()
    {
        return $this->pb_des_mur_misenoeuvre;
    }

    /**
     * Set pb_des_mur_revetement
     *
     * @param integer $pbDesMurRevetement
     * @return InfoSite
     */
    public function setPbDesMurRevetement($pbDesMurRevetement)
    {
        $this->pb_des_mur_revetement = $pbDesMurRevetement;

        return $this;
    }

    /**
     * Get pb_des_mur_revetement
     *
     * @return integer 
     */
    public function getPbDesMurRevetement()
    {
        return $this->pb_des_mur_revetement;
    }

    /**
     * Set pb_des_toit
     *
     * @param integer $pbDesToit
     * @return InfoSite
     */
    public function setPbDesToit($pbDesToit)
    {
        $this->pb_des_toit = $pbDesToit;

        return $this;
    }

    /**
     * Get pb_des_toit
     *
     * @return integer 
     */
    public function getPbDesToit()
    {
        return $this->pb_des_toit;
    }

    /**
     * Set pb_des_couvrement
     *
     * @param integer $pbDesCouvrement
     * @return InfoSite
     */
    public function setPbDesCouvrement($pbDesCouvrement)
    {
        $this->pb_des_couvrement = $pbDesCouvrement;

        return $this;
    }

    /**
     * Get pb_des_couvrement
     *
     * @return integer 
     */
    public function getPbDesCouvrement()
    {
        return $this->pb_des_couvrement;
    }

    /**
     * Set pb_des_complementaire
     *
     * @param string $pbDesComplementaire
     * @return InfoSite
     */
    public function setPbDesComplementaire($pbDesComplementaire)
    {
        $this->pb_des_complementaire = $pbDesComplementaire;

        return $this;
    }

    /**
     * Get pb_des_complementaire
     *
     * @return string 
     */
    public function getPbDesComplementaire()
    {
        return $this->pb_des_complementaire;
    }

    /**
     * Set pb_des_etat
     *
     * @param integer $pbDesEtat
     * @return InfoSite
     */
    public function setPbDesEtat($pbDesEtat)
    {
        $this->pb_des_etat = $pbDesEtat;

        return $this;
    }

    /**
     * Get pb_des_etat
     *
     * @return integer 
     */
    public function getPbDesEtat()
    {
        return $this->pb_des_etat;
    }

    /**
     * Set pb_interpretation
     *
     * @param integer $pbInterpretation
     * @return InfoSite
     */
    public function setPbInterpretation($pbInterpretation)
    {
        $this->pb_interpretation = $pbInterpretation;

        return $this;
    }

    /**
     * Get pb_interpretation
     *
     * @return integer 
     */
    public function getPbInterpretation()
    {
        return $this->pb_interpretation;
    }

    /**
     * Set pb_commentaire
     *
     * @param string $pbCommentaire
     * @return InfoSite
     */
    public function setPbCommentaire($pbCommentaire)
    {
        $this->pb_commentaire = $pbCommentaire;

        return $this;
    }

    /**
     * Get pb_commentaire
     *
     * @return string 
     */
    public function getPbCommentaire()
    {
        return $this->pb_commentaire;
    }

    /**
     * Set pb_traitement_donnees
     *
     * @param integer $pbTraitementDonnees
     * @return InfoSite
     */
    public function setPbTraitementDonnees($pbTraitementDonnees)
    {
        $this->pb_traitement_donnees = $pbTraitementDonnees;

        return $this;
    }

    /**
     * Get pb_traitement_donnees
     *
     * @return integer 
     */
    public function getPbTraitementDonnees()
    {
        return $this->pb_traitement_donnees;
    }

    /**
     * Set pb_source
     *
     * @param integer $pbSource
     * @return InfoSite
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

    /**
     * Set pb_dossiercandidature
     *
     * @param boolean $pbDossiercandidature
     * @return InfoSite
     */
    public function setPbDossiercandidature($pbDossiercandidature)
    {
        $this->pb_dossiercandidature = $pbDossiercandidature;

        return $this;
    }

    /**
     * Get pb_dossiercandidature
     *
     * @return boolean 
     */
    public function getPbDossiercandidature()
    {
        return $this->pb_dossiercandidature;
    }

    /**
     * Set parent_site
     *
     * @param \PNC\BaseAppBundle\Entity\Site $parentSite
     * @return InfoSite
     */
    public function setParentSite(\PNC\BaseAppBundle\Entity\Site $parentSite = null)
    {
        $this->parent_site = $parentSite;

        return $this;
    }

    /**
     * Get parent_site
     *
     * @return \PNC\BaseAppBundle\Entity\Site 
     */
    public function getParentSite()
    {
        return $this->parent_site;
    }
}
