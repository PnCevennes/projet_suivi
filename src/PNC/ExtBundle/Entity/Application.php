<?php

namespace PNC\ExtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 */
class Application
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $app_nom;


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
     * Set app_nom
     *
     * @param string $appNom
     * @return Application
     */
    public function setAppNom($appNom)
    {
        $this->app_nom = $appNom;

        return $this;
    }

    /**
     * Get app_nom
     *
     * @return string 
     */
    public function getAppNom()
    {
        return $this->app_nom;
    }
}
