<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteFichiers
 */
class SiteMenaces
{
    /**
     * @var integer
     */
    private $site_id;

    /**
     * @var integer
     */
    private $thesaurus_id;


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
    public function setThesaurusId($tId)
    {
        $this->thesaurus_id = $tId;

        return $this;
    }

    /**
     * Get fichier_id
     *
     * @return integer 
     */
    public function getThesaurusId()
    {
        return $this->thesaurus_id;
    }
}
