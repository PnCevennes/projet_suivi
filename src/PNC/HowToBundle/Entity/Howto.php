<?php

namespace PNC\HowToBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Howto
 */
class Howto extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $ht_nom;

    /**
     * @var integer
     */
    private $ht_valeur;

    /**
     * @var string
     */
    private $ht_commentaire;


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
     * Set ht_nom
     *
     * @param string $htNom
     * @return Howto
     */
    public function setHtNom($htNom)
    {
        if(strlen($htNom)>100){
            $this->add_error('htNom', 'La longueur doit être inférieure à 100 caractères');
        }
        $this->ht_nom = $htNom;

        return $this;
    }

    /**
     * Get ht_nom
     *
     * @return string 
     */
    public function getHtNom()
    {
        return $this->ht_nom;
    }

    /**
     * Set ht_valeur
     *
     * @param integer $htValeur
     * @return Howto
     */
    public function setHtValeur($htValeur)
    {
        $this->ht_valeur = $htValeur;

        return $this;
    }

    /**
     * Get ht_valeur
     *
     * @return integer 
     */
    public function getHtValeur()
    {
        return $this->ht_valeur;
    }

    /**
     * Set ht_commentaire
     *
     * @param string $htCommentaire
     * @return Howto
     */
    public function setHtCommentaire($htCommentaire)
    {
        if(strlen($htCommentaire)>1000){
            $this->add_error('htCommentaire', 'La longueur doit être inférieure à 1000 caractères');
        }
        $this->ht_commentaire = $htCommentaire;

        return $this;
    }

    /**
     * Get ht_commentaire
     *
     * @return string 
     */
    public function getHtCommentaire()
    {
        return $this->ht_commentaire;
    }
}
