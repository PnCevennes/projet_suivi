<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Site
 */
class Site extends BaseEntity
{

    //geometrie geoJson
    public $geom;
    /**
     * @var integer
     */

    /**
     * @var string
     */
    private $site_nom;

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
    private $site_code;

    /**
     * @var \DateTime
     */
    private $site_date;

    /**
     * @var string
     */
    private $site_description;

    /**
     * @var \PNC\ExtBundle\Entity\Observateur
     */
    private $observateur;

    /**
     * @var \PNC\ExtBundle\Entity\Lexique
     */
    private $site_type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $site_app;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->site_app = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    /**
     * Set site_nom
     *
     * @param string $siteNom
     * @return Site
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
     * Set observateur_id
     *
     * @param integer $observateurId
     * @return Site
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
     * @return Site
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
     * Set site_code
     *
     * @param string $siteCode
     * @return Site
     */
    public function setSiteCode($siteCode)
    {
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
     * @return Site
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
     * Set site_description
     *
     * @param string $siteDescription
     * @return Site
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
     * Set observateur
     *
     * @param \PNC\ExtBundle\Entity\Observateur $observateur
     * @return Site
     */
    public function setObservateur(\PNC\ExtBundle\Entity\Observateur $observateur = null)
    {
        $this->observateur = $observateur;

        return $this;
    }

    /**
     * Get observateur
     *
     * @return \PNC\ExtBundle\Entity\Observateur 
     */
    public function getObservateur()
    {
        return $this->observateur;
    }

    /**
     * Set site_type
     *
     * @param \PNC\ExtBundle\Entity\Lexique $siteType
     * @return Site
     */
    public function setSiteType(\PNC\ExtBundle\Entity\Lexique $siteType = null)
    {
        if($siteType == null){
            $this->_errors['siteType'] = "Type de lieu indéfini";
        }
        $this->site_type = $siteType;

        return $this;
    }

    /**
     * Get site_type
     *
     * @return \PNC\ExtBundle\Entity\Lexique 
     */
    public function getSiteType()
    {
        return $this->site_type;
    }

    /**
     * Add site_app
     *
     * @param \PNC\ExtBundle\Entity\Application $siteApp
     * @return Site
     */
    public function addSiteApp(\PNC\ExtBundle\Entity\Application $siteApp)
    {
        $this->site_app[] = $siteApp;

        return $this;
    }

    /**
     * Remove site_app
     *
     * @param \PNC\ExtBundle\Entity\Application $siteApp
     */
    public function removeSiteApp(\PNC\ExtBundle\Entity\Application $siteApp)
    {
        $this->site_app->removeElement($siteApp);
    }

    /**
     * Get site_app
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSiteApp()
    {
        return $this->site_app;
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
     * Set geom
     *
     * @param geometry $geom
     * @return Site
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return geometry 
     */
    public function getGeom()
    {
        return $this->geom;
    }
    /**
     * @var string
     */
    private $ref_commune;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;


    /**
     * Set ref_commune
     *
     * @param string $refCommune
     * @return Site
     */
    public function setRefCommune($refCommune)
    {
        $this->ref_commune = $refCommune;

        return $this;
    }

    /**
     * Get ref_commune
     *
     * @return string 
     */
    public function getRefCommune()
    {
        return $this->ref_commune;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Site
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
     * @return Site
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
     * @var integer
     */
    private $numerisateur_id;


    /**
     * Set numerisateur_id
     *
     * @param integer $numerisateurId
     * @return Site
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
}
