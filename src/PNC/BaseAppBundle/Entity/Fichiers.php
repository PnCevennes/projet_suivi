<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fichiers
 */
class Fichiers
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $path;


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
     * Set path
     *
     * @param string $path
     * @return Fichiers
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
}
