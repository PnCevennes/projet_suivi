<?php

namespace PNC\PatrimoineBatiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteMurGrosOeuvre
 */
class SiteMurGrosOeuvre
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
     * @return SiteMurGrosOeuvre
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
     * Set thesaurus_id
     *
     * @param integer $thesaurusId
     * @return SiteMurGrosOeuvre
     */
    public function setThesaurusId($thesaurusId)
    {
        $this->thesaurus_id = $thesaurusId;

        return $this;
    }

    /**
     * Get thesaurus_id
     *
     * @return integer 
     */
    public function getThesaurusId()
    {
        return $this->thesaurus_id;
    }
}
