<?php

namespace PNC\PatrimoineBatiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * InfoSite
 */
class InfoSite  extends BaseEntity
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
     * @var integer
     */
    private $pb_situation;

    /**
     * @var integer
     */
    private $pb_denomination;

    /**
     * @var string
     */
    private $pb_denomination_autre;

    /**
     * @var string
     */
    private $pb_nom_synononymes;

    /**
     * @var string
     */
    private $pb_code_ref;

    /**
     * @var integer
     */
    private $pb_orientation;

    /**
     * @var integer
     */
    private $pb_visibilite;

    /**
     * @var integer
     */
    private $pb_datation_siecle;

    /**
     * @var string
     */
    private $pb_datation_exacte;

    /**
     * @var float
     */
    private $pb_dimensions_larg;

    /**
     * @var float
     */
    private $pb_dimensions_long;

    /**
     * @var float
     */
    private $pb_dimensions_haut;

    /**
     * @var float
     */
    private $pb_dimensions_e;

    /**
     * @var float
     */
    private $pb_dimensions_d;

    /**
     * @var string
     */
    private $pb_environnement_proche;

    /**
     * @var integer
     */
    private $pb_description_mur;

    /**
     * @var integer
     */
    private $pb_description_couv;

    /**
     * @var integer
     */
    private $pb_description_toit;

    /**
     * @var string
     */
    private $pb_description_toit_precision;

    /**
     * @var integer
     */
    private $pb_description_baie;

    /**
     * @var string
     */
    private $pb_description_baie_precision;

    /**
     * @var string
     */
    private $pb_description_complementaire;

    /**
     * @var integer
     */
    private $pb_etat;

    /**
     * @var integer
     */
    private $pb_accessibilite;

    /**
     * @var integer
     */
    private $pb_statut;

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
     * Set pb_situation
     *
     * @param integer $pbSituation
     * @return InfoSite
     */
    public function setPbSituation($pbSituation)
    {
        $this->pb_situation = $pbSituation;

        return $this;
    }

    /**
     * Get pb_situation
     *
     * @return integer
     */
    public function getPbSituation()
    {
        return $this->pb_situation;
    }

    /**
     * Set pb_denomination
     *
     * @param integer $pbDenomination
     * @return InfoSite
     */
    public function setPbDenomination($pbDenomination)
    {
        $this->pb_denomination = $pbDenomination;

        return $this;
    }

    /**
     * Get pb_denomination
     *
     * @return integer
     */
    public function getPbDenomination()
    {
        return $this->pb_denomination;
    }

    /**
     * Set pb_denomination_autre
     *
     * @param string $pbDenominationAutre
     * @return InfoSite
     */
    public function setPbDenominationAutre($pbDenominationAutre)
    {
        $this->pb_denomination_autre = $pbDenominationAutre;

        return $this;
    }

    /**
     * Get pb_denomination_autre
     *
     * @return string
     */
    public function getPbDenominationAutre()
    {
        return $this->pb_denomination_autre;
    }

    /**
     * Set pb_nom_synononymes
     *
     * @param string $pbNomSynononymes
     * @return InfoSite
     */
    public function setPbNomSynononymes($pbNomSynononymes)
    {
        $this->pb_nom_synononymes = $pbNomSynononymes;

        return $this;
    }

    /**
     * Get pb_nom_synononymes
     *
     * @return string
     */
    public function getPbNomSynononymes()
    {
        return $this->pb_nom_synononymes;
    }

    /**
     * Set pb_code_ref
     *
     * @param string $pbCodeRef
     * @return InfoSite
     */
    public function setPbCodeRef($pbCodeRef)
    {
        $this->pb_code_ref = $pbCodeRef;

        return $this;
    }

    /**
     * Get pb_code_ref
     *
     * @return string
     */
    public function getPbCodeRef()
    {
        return $this->pb_code_ref;
    }

    /**
     * Set pb_orientation
     *
     * @param integer $pbOrientation
     * @return InfoSite
     */
    public function setPbOrientation($pbOrientation)
    {
        $this->pb_orientation = $pbOrientation;

        return $this;
    }

    /**
     * Get pb_orientation
     *
     * @return integer
     */
    public function getPbOrientation()
    {
        return $this->pb_orientation;
    }

    /**
     * Set pb_visibilite
     *
     * @param integer $pbVisibilite
     * @return InfoSite
     */
    public function setPbVisibilite($pbVisibilite)
    {
        $this->pb_visibilite = $pbVisibilite;

        return $this;
    }

    /**
     * Get pb_visibilite
     *
     * @return integer
     */
    public function getPbVisibilite()
    {
        return $this->pb_visibilite;
    }

    /**
     * Set pb_datation_siecle
     *
     * @param integer $pbDatationSiecle
     * @return InfoSite
     */
    public function setPbDatationSiecle($pbDatationSiecle)
    {
        $this->pb_datation_siecle = $pbDatationSiecle;

        return $this;
    }

    /**
     * Get pb_datation_siecle
     *
     * @return integer
     */
    public function getPbDatationSiecle()
    {
        return $this->pb_datation_siecle;
    }

    /**
     * Set pb_datation_exacte
     *
     * @param string $pbDatationExacte
     * @return InfoSite
     */
    public function setPbDatationExacte($pbDatationExacte)
    {
        $this->pb_datation_exacte = $pbDatationExacte;

        return $this;
    }

    /**
     * Get pb_datation_exacte
     *
     * @return string
     */
    public function getPbDatationExacte()
    {
        return $this->pb_datation_exacte;
    }

    /**
     * Set pb_dimensions_larg
     *
     * @param float $pbDimensionsLarg
     * @return InfoSite
     */
    public function setPbDimensionsLarg($pbDimensionsLarg)
    {
        $this->pb_dimensions_larg = $pbDimensionsLarg;

        return $this;
    }

    /**
     * Get pb_dimensions_larg
     *
     * @return float
     */
    public function getPbDimensionsLarg()
    {
        return $this->pb_dimensions_larg;
    }

    /**
     * Set pb_dimensions_long
     *
     * @param float $pbDimensionsLong
     * @return InfoSite
     */
    public function setPbDimensionsLong($pbDimensionsLong)
    {
        $this->pb_dimensions_long = $pbDimensionsLong;

        return $this;
    }

    /**
     * Get pb_dimensions_long
     *
     * @return float
     */
    public function getPbDimensionsLong()
    {
        return $this->pb_dimensions_long;
    }

    /**
     * Set pb_dimensions_haut
     *
     * @param float $pbDimensionsHaut
     * @return InfoSite
     */
    public function setPbDimensionsHaut($pbDimensionsHaut)
    {
        $this->pb_dimensions_haut = $pbDimensionsHaut;

        return $this;
    }

    /**
     * Get pb_dimensions_haut
     *
     * @return float
     */
    public function getPbDimensionsHaut()
    {
        return $this->pb_dimensions_haut;
    }

    /**
     * Set pb_dimensions_e
     *
     * @param float $pbDimensionsE
     * @return InfoSite
     */
    public function setPbDimensionsE($pbDimensionsE)
    {
        $this->pb_dimensions_e = $pbDimensionsE;

        return $this;
    }

    /**
     * Get pb_dimensions_e
     *
     * @return float
     */
    public function getPbDimensionsE()
    {
        return $this->pb_dimensions_e;
    }

    /**
     * Set pb_dimensions_d
     *
     * @param float $pbDimensionsD
     * @return InfoSite
     */
    public function setPbDimensionsD($pbDimensionsD)
    {
        $this->pb_dimensions_d = $pbDimensionsD;

        return $this;
    }

    /**
     * Get pb_dimensions_d
     *
     * @return float
     */
    public function getPbDimensionsD()
    {
        return $this->pb_dimensions_d;
    }

    /**
     * Set pb_environnement_proche
     *
     * @param string $pbEnvironnementProche
     * @return InfoSite
     */
    public function setPbEnvironnementProche($pbEnvironnementProche)
    {
        $this->pb_environnement_proche = $pbEnvironnementProche;

        return $this;
    }

    /**
     * Get pb_environnement_proche
     *
     * @return string
     */
    public function getPbEnvironnementProche()
    {
        return $this->pb_environnement_proche;
    }

    /**
     * Set pb_description_mur
     *
     * @param integer $pbDescriptionMur
     * @return InfoSite
     */
    public function setPbDescriptionMur($pbDescriptionMur)
    {
        $this->pb_description_mur = $pbDescriptionMur;

        return $this;
    }

    /**
     * Get pb_description_mur
     *
     * @return integer
     */
    public function getPbDescriptionMur()
    {
        return $this->pb_description_mur;
    }

    /**
     * Set pb_description_couv
     *
     * @param integer $pbDescriptionCouv
     * @return InfoSite
     */
    public function setPbDescriptionCouv($pbDescriptionCouv)
    {
        $this->pb_description_couv = $pbDescriptionCouv;

        return $this;
    }

    /**
     * Get pb_description_couv
     *
     * @return integer
     */
    public function getPbDescriptionCouv()
    {
        return $this->pb_description_couv;
    }

    /**
     * Set pb_description_toit
     *
     * @param integer $pbDescriptionToit
     * @return InfoSite
     */
    public function setPbDescriptionToit($pbDescriptionToit)
    {
        $this->pb_description_toit = $pbDescriptionToit;

        return $this;
    }

    /**
     * Get pb_description_toit
     *
     * @return integer
     */
    public function getPbDescriptionToit()
    {
        return $this->pb_description_toit;
    }

    /**
     * Set pb_description_toit_precision
     *
     * @param string $pbDescriptionToitPrecision
     * @return InfoSite
     */
    public function setPbDescriptionToitPrecision($pbDescriptionToitPrecision)
    {
        $this->pb_description_toit_precision = $pbDescriptionToitPrecision;

        return $this;
    }

    /**
     * Get pb_description_toit_precision
     *
     * @return string
     */
    public function getPbDescriptionToitPrecision()
    {
        return $this->pb_description_toit_precision;
    }

    /**
     * Set pb_description_baie
     *
     * @param integer $pbDescriptionBaie
     * @return InfoSite
     */
    public function setPbDescriptionBaie($pbDescriptionBaie)
    {
        $this->pb_description_baie = $pbDescriptionBaie;

        return $this;
    }

    /**
     * Get pb_description_baie
     *
     * @return integer
     */
    public function getPbDescriptionBaie()
    {
        return $this->pb_description_baie;
    }

    /**
     * Set pb_description_baie_precision
     *
     * @param string $pbDescriptionBaiePrecision
     * @return InfoSite
     */
    public function setPbDescriptionBaiePrecision($pbDescriptionBaiePrecision)
    {
        $this->pb_description_baie_precision = $pbDescriptionBaiePrecision;

        return $this;
    }

    /**
     * Get pb_description_baie_precision
     *
     * @return string
     */
    public function getPbDescriptionBaiePrecision()
    {
        return $this->pb_description_baie_precision;
    }

    /**
     * Set pb_description_complementaire
     *
     * @param string $pbDescriptionComplementaire
     * @return InfoSite
     */
    public function setPbDescriptionComplementaire($pbDescriptionComplementaire)
    {
        $this->pb_description_complementaire = $pbDescriptionComplementaire;

        return $this;
    }

    /**
     * Get pb_description_complementaire
     *
     * @return string
     */
    public function getPbDescriptionComplementaire()
    {
        return $this->pb_description_complementaire;
    }

    /**
     * Set pb_etat
     *
     * @param integer $pbEtat
     * @return InfoSite
     */
    public function setPbEtat($pbEtat)
    {
        $this->pb_etat = $pbEtat;

        return $this;
    }

    /**
     * Get pb_etat
     *
     * @return integer
     */
    public function getPbEtat()
    {
        return $this->pb_etat;
    }

    /**
     * Set pb_accessibilite
     *
     * @param integer $pbAccessibilite
     * @return InfoSite
     */
    public function setPbAccessibilite($pbAccessibilite)
    {
        $this->pb_accessibilite = $pbAccessibilite;

        return $this;
    }

    /**
     * Get pb_accessibilite
     *
     * @return integer
     */
    public function getPbAccessibilite()
    {
        return $this->pb_accessibilite;
    }

    /**
     * Set pb_statut
     *
     * @param integer $pbStatut
     * @return InfoSite
     */
    public function setPbStatut($pbStatut)
    {
        $this->pb_statut = $pbStatut;

        return $this;
    }

    /**
     * Get pb_statut
     *
     * @return integer
     */
    public function getPbStatut()
    {
        return $this->pb_statut;
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
