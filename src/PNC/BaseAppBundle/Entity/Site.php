<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 */
class Site
{

    private $_errors = array();

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
        if(strlen($siteCode)<5 || strlen($siteCode)>25){
            $this->_errors['siteCode'] = "le code doit faire entre 5 et 25 caractères";
        }
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
}
