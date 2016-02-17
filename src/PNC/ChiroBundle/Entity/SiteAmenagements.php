<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * SiteMenaces
 */
class SiteAmenagements extends BaseEntity
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
     * @return SiteMenaces
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
     * @return SiteMenaces
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
