<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteFichiers
 */
class ObstaxonFichiers
{
    /**
     * @var integer
     */
    private $cotx_id;

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
    public function setCotxId($cotxId)
    {
        $this->cotx_id = $cotxId;

        return $this;
    }

    /**
     * Get site_id
     *
     * @return integer 
     */
    public function getCotxId()
    {
        return $this->cotx_id;
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

