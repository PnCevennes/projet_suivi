<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxons
 */
class Taxons
{
    /**
     * @var integer
     */
    private $cd_nom;

    /**
     * @var string
     */
    private $ordre;

    /**
     * @var string
     */
    private $nom_complet;


    /**
     * Set cd_nom
     *
     * @param integer $cdNom
     * @return Taxons
     */
    public function setCdNom($cdNom)
    {
        $this->cd_nom = $cdNom;

        return $this;
    }

    /**
     * Get cd_nom
     *
     * @return integer 
     */
    public function getCdNom()
    {
        return $this->cd_nom;
    }

    /**
     * Set ordre
     *
     * @param string $ordre
     * @return Taxons
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return string 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set nom_complet
     *
     * @param string $nomComplet
     * @return Taxons
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
}
