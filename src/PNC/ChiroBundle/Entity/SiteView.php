<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * SiteView
 */
class SiteView extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $bs_nom;

    /**
     * @var string
     */
    private $bs_code;

    /**
     * @var \DateTime
     */
    private $bs_date;

    /**
     * @var array
     */
    private $geom;

    /**
     * @var string
     */
    private $nom_observateur;

    /**
     * @var integer
     */
    private $bs_obr_id;

    /**
     * @var integer
     */
    private $bs_type_id;

    /**
     * @var string
     */
    private $type_lieu;

    /**
     * @var string
     */
    private $bs_description;

    /**
     * @var string
     */
    private $cis_frequentation;

    /**
     * @var string
     */
    private $cis_menace;

    /**
     * @var string
     */
    private $cis_menace_cmt;

    /**
     * @var string
     */
    private $cis_actions;

    /**
     * @var array
     */
    private $site_fichiers;

    /**
     * @var string
     */
    private $cis_contact_nom;

    /**
     * @var string
     */
    private $cis_contact_prenom;

    /**
     * @var string
     */
    private $cis_contact_adresse;

    /**
     * @var string
     */
    private $cis_contact_code_postal;

    /**
     * @var string
     */
    private $cis_contact_ville;

    /**
     * @var string
     */
    private $cis_contact_telephone;

    /**
     * @var string
     */
    private $cis_contact_portable;

    /**
     * @var string
     */
    private $cis_contact_commentaire;

    /**
     * @var boolean
     */
    private $cis_site_actif;

    /**
     * @var \DateTime
     */
    private $dern_obs;

    /**
     * @var integer
     */
    private $nb_obs;

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
     * @var array
     */
    private $ref_commune;


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
     * Set bs_nom
     *
     * @param string $bsNom
     * @return SiteView
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
     * Set bs_code
     *
     * @param string $bsCode
     * @return SiteView
     */
    public function setBsCode($bsCode)
    {
        $this->bs_code = $bsCode;

        return $this;
    }

    /**
     * Get bs_code
     *
     * @return string 
     */
    public function getBsCode()
    {
        return $this->bs_code;
    }

    /**
     * Set bs_date
     *
     * @param \DateTime $bsDate
     * @return SiteView
     */
    public function setBsDate($bsDate)
    {
        $this->bs_date = $bsDate;

        return $this;
    }

    /**
     * Get bs_date
     *
     * @return \DateTime 
     */
    public function getBsDate()
    {
        return $this->bs_date;
    }

    /**
     * Set geom
     *
     * @param array $geom
     * @return SiteView
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
     * Set nom_observateur
     *
     * @param string $nomObservateur
     * @return SiteView
     */
    public function setNomObservateur($nomObservateur)
    {
        $this->nom_observateur = $nomObservateur;

        return $this;
    }

    /**
     * Get nom_observateur
     *
     * @return string 
     */
    public function getNomObservateur()
    {
        return $this->nom_observateur;
    }

    /**
     * Set bs_obr_id
     *
     * @param integer $bsObrId
     * @return SiteView
     */
    public function setBsObrId($bsObrId)
    {
        $this->bs_obr_id = $bsObrId;

        return $this;
    }

    /**
     * Get bs_obr_id
     *
     * @return integer 
     */
    public function getBsObrId()
    {
        return $this->bs_obr_id;
    }

    /**
     * Set bs_type_id
     *
     * @param integer $bsTypeId
     * @return SiteView
     */
    public function setBsTypeId($bsTypeId)
    {
        $this->bs_type_id = $bsTypeId;

        return $this;
    }

    /**
     * Get bs_type_id
     *
     * @return integer 
     */
    public function getBsTypeId()
    {
        return $this->bs_type_id;
    }

    /**
     * Set type_lieu
     *
     * @param string $typeLieu
     * @return SiteView
     */
    public function setTypeLieu($typeLieu)
    {
        $this->type_lieu = $typeLieu;

        return $this;
    }

    /**
     * Get type_lieu
     *
     * @return string 
     */
    public function getTypeLieu()
    {
        return $this->type_lieu;
    }

    /**
     * Set bs_description
     *
     * @param string $bsDescription
     * @return SiteView
     */
    public function setBsDescription($bsDescription)
    {
        $this->bs_description = $bsDescription;

        return $this;
    }

    /**
     * Get bs_description
     *
     * @return string 
     */
    public function getBsDescription()
    {
        return $this->bs_description;
    }

    /**
     * Set cis_frequentation
     *
     * @param string $cisFrequentation
     * @return SiteView
     */
    public function setCisFrequentation($cisFrequentation)
    {
        $this->cis_frequentation = $cisFrequentation;

        return $this;
    }

    /**
     * Get cis_frequentation
     *
     * @return string 
     */
    public function getCisFrequentation()
    {
        return $this->cis_frequentation;
    }

    /**
     * Set cis_menace
     *
     * @param string $cisMenace
     * @return SiteView
     */
    public function setCisMenace($cisMenace)
    {
        $this->cis_menace = $cisMenace;

        return $this;
    }

    /**
     * Get cis_menace
     *
     * @return string 
     */
    public function getCisMenace()
    {
        return $this->cis_menace;
    }

    /**
     * Set cis_menace_cmt
     *
     * @param string $cisMenaceCmt
     * @return SiteView
     */
    public function setCisMenaceCmt($cisMenaceCmt)
    {
        $this->cis_menace_cmt = $cisMenaceCmt;

        return $this;
    }

    /**
     * Get cis_menace_cmt
     *
     * @return string 
     */
    public function getCisMenaceCmt()
    {
        return $this->cis_menace_cmt;
    }

    /**
     * Set cis_actions
     *
     * @param string $cisActions
     * @return SiteView
     */
    public function setCisActions($cisActions)
    {
        $this->cis_actions = $cisActions;

        return $this;
    }

    /**
     * Get cis_actions
     *
     * @return string 
     */
    public function getCisActions()
    {
        return $this->cis_actions;
    }

    /**
     * Set site_fichiers
     *
     * @param array $siteFichiers
     * @return SiteView
     */
    public function setSiteFichiers($siteFichiers)
    {
        $this->site_fichiers = $siteFichiers;

        return $this;
    }

    /**
     * Get site_fichiers
     *
     * @return array 
     */
    public function getSiteFichiers()
    {
        return $this->site_fichiers;
    }

    /**
     * Set cis_contact_nom
     *
     * @param string $cisContactNom
     * @return SiteView
     */
    public function setCisContactNom($cisContactNom)
    {
        $this->cis_contact_nom = $cisContactNom;

        return $this;
    }

    /**
     * Get cis_contact_nom
     *
     * @return string 
     */
    public function getCisContactNom()
    {
        return $this->cis_contact_nom;
    }

    /**
     * Set cis_contact_prenom
     *
     * @param string $cisContactPrenom
     * @return SiteView
     */
    public function setCisContactPrenom($cisContactPrenom)
    {
        $this->cis_contact_prenom = $cisContactPrenom;

        return $this;
    }

    /**
     * Get cis_contact_prenom
     *
     * @return string 
     */
    public function getCisContactPrenom()
    {
        return $this->cis_contact_prenom;
    }

    /**
     * Set cis_contact_adresse
     *
     * @param string $cisContactAdresse
     * @return SiteView
     */
    public function setCisContactAdresse($cisContactAdresse)
    {
        $this->cis_contact_adresse = $cisContactAdresse;

        return $this;
    }

    /**
     * Get cis_contact_adresse
     *
     * @return string 
     */
    public function getCisContactAdresse()
    {
        return $this->cis_contact_adresse;
    }

    /**
     * Set cis_contact_code_postal
     *
     * @param string $cisContactCodePostal
     * @return SiteView
     */
    public function setCisContactCodePostal($cisContactCodePostal)
    {
        $this->cis_contact_code_postal = $cisContactCodePostal;

        return $this;
    }

    /**
     * Get cis_contact_code_postal
     *
     * @return string 
     */
    public function getCisContactCodePostal()
    {
        return $this->cis_contact_code_postal;
    }

    /**
     * Set cis_contact_ville
     *
     * @param string $cisContactVille
     * @return SiteView
     */
    public function setCisContactVille($cisContactVille)
    {
        $this->cis_contact_ville = $cisContactVille;

        return $this;
    }

    /**
     * Get cis_contact_ville
     *
     * @return string 
     */
    public function getCisContactVille()
    {
        return $this->cis_contact_ville;
    }

    /**
     * Set cis_contact_telephone
     *
     * @param string $cisContactTelephone
     * @return SiteView
     */
    public function setCisContactTelephone($cisContactTelephone)
    {
        $this->cis_contact_telephone = $cisContactTelephone;

        return $this;
    }

    /**
     * Get cis_contact_telephone
     *
     * @return string 
     */
    public function getCisContactTelephone()
    {
        return $this->cis_contact_telephone;
    }

    /**
     * Set cis_contact_portable
     *
     * @param string $cisContactPortable
     * @return SiteView
     */
    public function setCisContactPortable($cisContactPortable)
    {
        $this->cis_contact_portable = $cisContactPortable;

        return $this;
    }

    /**
     * Get cis_contact_portable
     *
     * @return string 
     */
    public function getCisContactPortable()
    {
        return $this->cis_contact_portable;
    }

    /**
     * Set cis_contact_commentaire
     *
     * @param string $cisContactCommentaire
     * @return SiteView
     */
    public function setCisContactCommentaire($cisContactCommentaire)
    {
        $this->cis_contact_commentaire = $cisContactCommentaire;

        return $this;
    }

    /**
     * Get cis_contact_commentaire
     *
     * @return string 
     */
    public function getCisContactCommentaire()
    {
        return $this->cis_contact_commentaire;
    }

    /**
     * Set cis_site_actif
     *
     * @param boolean $cisSiteActif
     * @return SiteView
     */
    public function setCisSiteActif($cisSiteActif)
    {
        $this->cis_site_actif = $cisSiteActif;

        return $this;
    }

    /**
     * Get cis_site_actif
     *
     * @return boolean 
     */
    public function getCisSiteActif()
    {
        return $this->cis_site_actif;
    }

    /**
     * Set dern_obs
     *
     * @param \DateTime $dernObs
     * @return SiteView
     */
    public function setDernObs($dernObs)
    {
        $this->dern_obs = $dernObs;

        return $this;
    }

    /**
     * Get dern_obs
     *
     * @return \DateTime 
     */
    public function getDernObs()
    {
        return $this->dern_obs;
    }

    /**
     * Set nb_obs
     *
     * @param integer $nbObs
     * @return SiteView
     */
    public function setNbObs($nbObs)
    {
        $this->nb_obs = $nbObs;

        return $this;
    }

    /**
     * Get nb_obs
     *
     * @return integer 
     */
    public function getNbObs()
    {
        return $this->nb_obs;
    }

    /**
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return SiteView
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
     * @return SiteView
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
     * @return SiteView
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
     * Set ref_commune
     *
     * @param array $refCommune
     * @return SiteView
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
}
