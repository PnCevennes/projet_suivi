<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteFichiers
 */
class SiteFichiers
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
}
