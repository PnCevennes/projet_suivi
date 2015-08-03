<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * InfoSite
 */
class InfoSite extends BaseEntity
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
     * @var string
     */
    private $site_description;

    /**
     * @var string
     */
    private $site_schema;

    /**
     * @var integer
     *
     */
    private $site_frequentation;

    /**
     * @var integer
     */
    private $site_menace;

    /**
     * @var string
     */
    private $site_menace_cmt;

    /**
     * @var string
     */
    private $site_commentaire;

    /**
     * @var string
     */
    private $contact_nom;

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
     * @return InfoSite
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
     * Set site_description
     *
     * @param string $siteDescription
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * Set site_commentaire
     *
     * @param string $siteCommentaire
     * @return InfoSite
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
     * Set contact_nom
     *
     * @param string $contactNom
     * @return InfoSite
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
     * Set contact_prenom
     *
     * @param string $contactPrenom
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @return InfoSite
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
     * @var \PNC\BaseAppBundle\Entity\Site
     */
    private $parent_site;


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
