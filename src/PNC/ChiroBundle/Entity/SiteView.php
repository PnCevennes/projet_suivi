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
     * @var jsonArray
     */
    private $geom;

    /**
     * @var string
     */
    private $contact_nom;


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
     * @param \jsonArray $geom
     * @return SiteView
     */
    public function setGeom( $geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return \jsonArray 
     */
    public function getGeom()
    {
        return $this->geom;
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
     * @var string
     */
    private $description_generale;

    /**
     * @var string
     */
    private $nom_observateur;

    /**
     * @var string
     */
    private $type_lieu;

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
     * @var string
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
     * Set description_generale
     *
     * @param string $descriptionGenerale
     * @return SiteView
     */
    public function setDescriptionGenerale($descriptionGenerale)
    {
        $this->description_generale = $descriptionGenerale;

        return $this;
    }

    /**
     * Get description_generale
     *
     * @return string 
     */
    public function getDescriptionGenerale()
    {
        return $this->description_generale;
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

    public function setSiteMenaceCmt($siteMenaceCmt){
        $this->site_menace_cmt = $siteMenaceCmt;
    }

    public function getSiteMenaceCmt(){
        return $this->site_menace_cmt;
    }

    /**
     * Set site_amenagement
     *
     * @param string $siteAmenagement
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
     * @return string 
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
     * @var integer
     */
    private $nb_obs;

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
     * @var \DateTime
     */
    private $dern_obs;


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
     * @var integer
     */
    private $type_id;


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

    private $observateur_id;

    public function setObservateurId($observateurId){
        $this->observateur_id = $observateurId;
        return $this;
    }

    public function getObservateurId(){
        return $this->observateur_id;
    }
    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;


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
     * @var array
     */
    private $ref_commune;


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
