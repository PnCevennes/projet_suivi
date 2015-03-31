<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObservateurView
 */
class ObservateurView
{
    /**
     * @var integer
     */
    private $obr_id;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $obr_nom;

    /**
     * @var string
     */
    private $obr_prenom;

    /**
     * @var string
     */
    private $nom_complet;

    /**
     * @var string
     */
    private $nom_complet_lower;


    /**
     * Set obr_id
     *
     * @param integer $obrId
     * @return ObservateurView
     */
    public function setObrId($obrId)
    {
        $this->obr_id = $obrId;

        return $this;
    }

    /**
     * Get obr_id
     *
     * @return integer 
     */
    public function getObrId()
    {
        return $this->obr_id;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return ObservateurView
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set obr_nom
     *
     * @param string $obrNom
     * @return ObservateurView
     */
    public function setObrNom($obrNom)
    {
        $this->obr_nom = $obrNom;

        return $this;
    }

    /**
     * Get obr_nom
     *
     * @return string 
     */
    public function getObrNom()
    {
        return $this->obr_nom;
    }

    /**
     * Set obr_prenom
     *
     * @param string $obrPrenom
     * @return ObservateurView
     */
    public function setObrPrenom($obrPrenom)
    {
        $this->obr_prenom = $obrPrenom;

        return $this;
    }

    /**
     * Get obr_prenom
     *
     * @return string 
     */
    public function getObrPrenom()
    {
        return $this->obr_prenom;
    }

    /**
     * Set nom_complet
     *
     * @param string $nomComplet
     * @return ObservateurView
     */
    public function setNomComplet($nomComplet)
    {
        $this->nom_complet = $nomComplet;

        return $this;
    }

    /**
     * Get nom_complet
     *
     * @return string 
     */
    public function getNomComplet()
    {
        return $this->nom_complet;
    }

    /**
     * Set nom_complet_lower
     *
     * @param string $nomCompletLower
     * @return ObservateurView
     */
    public function setNomCompletLower($nomCompletLower)
    {
        $this->nom_complet_lower = $nomCompletLower;

        return $this;
    }

    /**
     * Get nom_complet_lower
     *
     * @return string 
     */
    public function getNomCompletLower()
    {
        return $this->nom_complet_lower;
    }
}
