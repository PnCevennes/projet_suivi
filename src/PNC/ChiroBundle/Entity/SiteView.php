<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteView
 */
class SiteView
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $site_nom;

    /**
     * @var string
     */
    private $site_code;

    /**
     * @var \DateTime
     */
    private $site_date;

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
    private $observateur_id;

    /**
     * @var integer
     */
    private $type_id;

    /**
     * @var string
     */
    private $type_lieu;

    /**
     * @var string
     */
    private $contact_nom;

    /**
     * @var string
     */
    private $site_description;

    /**
     * @var string
     */
    private $site_schema;

    /**
     * @var string
     */
    private $site_frequentation;

    /**
     * @var string
     */
    private $site_menace;

    /**
     * @var string
     */
    private $site_menace_cmt;

    /**
     * @var array
     */
    private $site_amenagement;

    /**
     * @var string
     */
    private $site_commentaire;

    /**
     * @var string
     */
    private $contact_prenom;

    /**
     * @var string
     */
    private $contact_adresse;

    /**
     * @var string
     */
    private $contact_code_postal;

    /**
     * @var string
     */
    private $contact_ville;

    /**
     * @var string
     */
    private $contact_telephone;

    /**
     * @var string
     */
    private $contact_portable;

    /**
     * @var string
     */
    private $contact_commentaire;

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
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var integer
     */
    private $numerisateur_id;

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
     * Set site_nom
     *
     * @param string $siteNom
     * @return SiteView
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
     * Set site_code
     *
     * @param string $siteCode
     * @return SiteView
     */
    public function setSiteCode($siteCode)
    {
        $this->site_code = $siteCode;

        return $this;
    }

    /**
     * Get site_code
     *
     * @return string 
     */
    public function getSiteCode()
    {
        return $this->site_code;
    }

    /**
     * Set site_date
     *
     * @param \DateTime $siteDate
     * @return SiteView
     */
    public function setSiteDate($siteDate)
    {
        $this->site_date = $siteDate;

        return $this;
    }

    /**
     * Get site_date
     *
     * @return \DateTime 
     */
    public function getSiteDate()
    {
        return $this->site_date;
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
     * Set observateur_id
     *
     * @param integer $observateurId
     * @return SiteView
     */
    public function setObservateurId($observateurId)
    {
        $this->observateur_id = $observateurId;

        return $this;
    }

    /**
     * Get observateur_id
     *
     * @return integer 
     */
    public function getObservateurId()
    {
        return $this->observateur_id;
    }

    /**
     * Set type_id
     *
     * @param integer $typeId
     * @return SiteView
     */
    public function setTypeId($typeId)
    {
        $this->type_id = $typeId;

        return $this;
    }

    /**
     * Get type_id
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->type_id;
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
     * Set contact_nom
     *
     * @param string $contactNom
     * @return SiteView
     */
    public function setContactNom($contactNom)
    {
        $this->contact_nom = $contactNom;

        return $this;
    }

    /**
     * Get contact_nom
     *
     * @return string 
     */
    public function getContactNom()
    {
        return $this->contact_nom;
    }

    /**
     * Set site_description
     *
     * @param string $siteDescription
     * @return SiteView
     */
    public function setSiteDescription($siteDescription)
    {
        $this->site_description = $siteDescription;

        return $this;
    }

    /**
     * Get site_description
     *
     * @return string 
     */
    public function getSiteDescription()
    {
        return $this->site_description;
    }

    /**
     * Set site_schema
     *
     * @param string $siteSchema
     * @return SiteView
     */
    public function setSiteSchema($siteSchema)
    {
        $this->site_schema = $siteSchema;

        return $this;
    }

    /**
     * Get site_schema
     *
     * @return string 
     */
    public function getSiteSchema()
    {
        return $this->site_schema;
    }

    /**
     * Set site_frequentation
     *
     * @param string $siteFrequentation
     * @return SiteView
     */
    public function setSiteFrequentation($siteFrequentation)
    {
        $this->site_frequentation = $siteFrequentation;

        return $this;
    }

    /**
     * Get site_frequentation
     *
     * @return string 
     */
    public function getSiteFrequentation()
    {
        return $this->site_frequentation;
    }

    /**
     * Set site_menace
     *
     * @param string $siteMenace
     * @return SiteView
     */
    public function setSiteMenace($siteMenace)
    {
        $this->site_menace = $siteMenace;

        return $this;
    }

    /**
     * Get site_menace
     *
     * @return string 
     */
    public function getSiteMenace()
    {
        return $this->site_menace;
    }

    /**
     * Set site_menace_cmt
     *
     * @param string $siteMenaceCmt
     * @return SiteView
     */
    public function setSiteMenaceCmt($siteMenaceCmt)
    {
        $this->site_menace_cmt = $siteMenaceCmt;

        return $this;
    }

    /**
     * Get site_menace_cmt
     *
     * @return string 
     */
    public function getSiteMenaceCmt()
    {
        return $this->site_menace_cmt;
    }

    /**
     * Set site_amenagement
     *
     * @param array $siteAmenagement
     * @return SiteView
     */
    public function setSiteAmenagement($siteAmenagement)
    {
        $this->site_amenagement = $siteAmenagement;

        return $this;
    }

    /**
     * Get site_amenagement
     *
     * @return array 
     */
    public function getSiteAmenagement()
    {
        return $this->site_amenagement;
    }

    /**
     * Set site_commentaire
     *
     * @param string $siteCommentaire
     * @return SiteView
     */
    public function setSiteCommentaire($siteCommentaire)
    {
        $this->site_commentaire = $siteCommentaire;

        return $this;
    }

    /**
     * Get site_commentaire
     *
     * @return string 
     */
    public function getSiteCommentaire()
    {
        return $this->site_commentaire;
    }

    /**
     * Set contact_prenom
     *
     * @param string $contactPrenom
     * @return SiteView
     */
    public function setContactPrenom($contactPrenom)
    {
        $this->contact_prenom = $contactPrenom;

        return $this;
    }

    /**
     * Get contact_prenom
     *
     * @return string 
     */
    public function getContactPrenom()
    {
        return $this->contact_prenom;
    }

    /**
     * Set contact_adresse
     *
     * @param string $contactAdresse
     * @return SiteView
     */
    public function setContactAdresse($contactAdresse)
    {
        $this->contact_adresse = $contactAdresse;

        return $this;
    }

    /**
     * Get contact_adresse
     *
     * @return string 
     */
    public function getContactAdresse()
    {
        return $this->contact_adresse;
    }

    /**
     * Set contact_code_postal
     *
     * @param string $contactCodePostal
     * @return SiteView
     */
    public function setContactCodePostal($contactCodePostal)
    {
        $this->contact_code_postal = $contactCodePostal;

        return $this;
    }

    /**
     * Get contact_code_postal
     *
     * @return string 
     */
    public function getContactCodePostal()
    {
        return $this->contact_code_postal;
    }

    /**
     * Set contact_ville
     *
     * @param string $contactVille
     * @return SiteView
     */
    public function setContactVille($contactVille)
    {
        $this->contact_ville = $contactVille;

        return $this;
    }

    /**
     * Get contact_ville
     *
     * @return string 
     */
    public function getContactVille()
    {
        return $this->contact_ville;
    }

    /**
     * Set contact_telephone
     *
     * @param string $contactTelephone
     * @return SiteView
     */
    public function setContactTelephone($contactTelephone)
    {
        $this->contact_telephone = $contactTelephone;

        return $this;
    }

    /**
     * Get contact_telephone
     *
     * @return string 
     */
    public function getContactTelephone()
    {
        return $this->contact_telephone;
    }

    /**
     * Set contact_portable
     *
     * @param string $contactPortable
     * @return SiteView
     */
    public function setContactPortable($contactPortable)
    {
        $this->contact_portable = $contactPortable;

        return $this;
    }

    /**
     * Get contact_portable
     *
     * @return string 
     */
    public function getContactPortable()
    {
        return $this->contact_portable;
    }

    /**
     * Set contact_commentaire
     *
     * @param string $contactCommentaire
     * @return SiteView
     */
    public function setContactCommentaire($contactCommentaire)
    {
        $this->contact_commentaire = $contactCommentaire;

        return $this;
    }

    /**
     * Get contact_commentaire
     *
     * @return string 
     */
    public function getContactCommentaire()
    {
        return $this->contact_commentaire;
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
     * Set created
     *
     * @param \DateTime $created
     * @return SiteView
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return SiteView
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set numerisateur_id
     *
     * @param integer $numerisateurId
     * @return SiteView
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
    private $cis_description;

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
    private $cis_commentaire;

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
     * Set cis_description
     *
     * @param string $cisDescription
     * @return SiteView
     */
    public function setCisDescription($cisDescription)
    {
        $this->cis_description = $cisDescription;

        return $this;
    }

    /**
     * Get cis_description
     *
     * @return string 
     */
    public function getCisDescription()
    {
        return $this->cis_description;
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
     * Set cis_commentaire
     *
     * @param string $cisCommentaire
     * @return SiteView
     */
    public function setCisCommentaire($cisCommentaire)
    {
        $this->cis_commentaire = $cisCommentaire;

        return $this;
    }

    /**
     * Get cis_commentaire
     *
     * @return string 
     */
    public function getCisCommentaire()
    {
        return $this->cis_commentaire;
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
     * @var string
     */
    private $bs_description;


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
}
