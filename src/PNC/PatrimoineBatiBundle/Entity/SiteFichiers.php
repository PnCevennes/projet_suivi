<?php

namespace PNC\PatrimoineBatiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * SiteFichiers
 */
class SiteFichiers extends BaseEntity
{
    /**
     * @var integer
     */
    private $site_id;

    /**
     * @var integer
     */
    private $fichier_id;

    /**
     * @var string
     */
    private $commentaire;

    public function __construct($site_id=null, $fichier_id=null, $commentaire=null){
        $this->setSiteId($site_id);
        $this->setFichierId($fichier_id);
        $this->setCommentaire($commentaire);
    }
    
    /**
     * Set site_id
     *
     * @param integer $siteId
     * @return SiteFichiers
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
     * Set fichier_id
     *
     * @param integer $fichierId
     * @return SiteFichiers
     */
    public function setFichierId($fichierId)
    {
        $this->fichier_id = $fichierId;

        return $this;
    }

    /**
     * Get fichier_id
     *
     * @return integer
     */
    public function getFichierId()
    {
        return $this->fichier_id;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return SiteFichiers
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
