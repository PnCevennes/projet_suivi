<?php

namespace PNC\BaseAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observateurs
 */
class Observateurs
{
    /**
     * @var integer
     */
    private $id_role;

    /**
     * @var string
     */
    private $nom_role;

    /**
     * @var string
     */
    private $prenom_role;


    /**
     * Get id_role
     *
     * @return integer 
     */
    public function getIdRole()
    {
        return $this->id_role;
    }

    /**
     * Set nom_role
     *
     * @param string $nomRole
     * @return Observateurs
     */
    public function setNomRole($nomRole)
    {
        $this->nom_role = $nomRole;

        return $this;
    }

    /**
     * Get nom_role
     *
     * @return string 
     */
    public function getNomRole()
    {
        return $this->nom_role;
    }

    /**
     * Set prenom_role
     *
     * @param string $prenomRole
     * @return Observateurs
     */
    public function setPrenomRole($prenomRole)
    {
        $this->prenom_role = $prenomRole;

        return $this;
    }

    /**
     * Get prenom_role
     *
     * @return string 
     */
    public function getPrenomRole()
    {
        return $this->prenom_role;
    }
}
