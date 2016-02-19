<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * ObstaxonFichiers
 */
class ObstaxonIndices extends BaseEntity
{
    /**
     * @var integer
     */
    private $cotx_id;

    /**
     * @var integer
     */
    private $thesaurus_id;


    /**
     * Set cotx_id
     *
     * @param integer $cotxId
     * @return ObstaxonFichiers
     */
    public function setCotxId($cotxId)
    {
        $this->cotx_id = $cotxId;

        return $this;
    }

    /**
     * Get cotx_id
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
     * @return ObstaxonFichiers
     */
    public function setThesaurusId($fichierId)
    {
        $this->thesaurus_id= $fichierId;

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
    /**
     * @var integer
     */

}
