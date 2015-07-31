<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * Biometrie
 */
class Biometrie extends BaseEntity
{

    /**
     * @var integer
     */
    private $biom_id;

    /**
     * @var integer
     */
    private $age_id;

    /**
     * @var integer
     */
    private $sexe_id;

    /**
     * @var string
     */
    private $biom_ab;

    /**
     * @var string
     */
    private $biom_poids;

    /**
     * @var string
     */
    private $biom_d3mf1;

    /**
     * @var string
     */
    private $biom_d3f2f3;

    /**
     * @var string
     */
    private $biom_d3total;

    /**
     * @var string
     */
    private $biom_d5;

    /**
     * @var string
     */
    private $biom_cm3sup;

    /**
     * @var string
     */
    private $biom_cm3inf;

    /**
     * @var string
     */
    private $biom_cb;

    /**
     * @var string
     */
    private $biom_lm;

    /**
     * @var string
     */
    private $biom_oreille;

    /**
     * @var string
     */
    private $biom_commentaire;


    /**
     * Get biom_id
     *
     * @return integer 
     */
    public function getBiomId()
    {
        return $this->biom_id;
    }

    /**
     * Set age_id
     *
     * @param integer $ageId
     * @return Biometrie
     */
    public function setAgeId($ageId)
    {
        $this->age_id = $ageId;

        return $this;
    }

    /**
     * Get age_id
     *
     * @return integer 
     */
    public function getAgeId()
    {
        return $this->age_id;
    }

    /**
     * Set sexe_id
     *
     * @param integer $sexeId
     * @return Biometrie
     */
    public function setSexeId($sexeId)
    {
        $this->sexe_id = $sexeId;

        return $this;
    }

    /**
     * Get sexe_id
     *
     * @return integer 
     */
    public function getSexeId()
    {
        return $this->sexe_id;
    }

    /**
     * Set biom_ab
     *
     * @param string $biomAb
     * @return Biometrie
     */
    public function setBiomAb($biomAb)
    {
        if($biomAb && !is_numeric($biomAb)){
            $this->_errors['biomAb'] = "Cette valeur est numérique !";
        }
        else $this->biom_ab = $biomAb;

        return $this;
    }

    /**
     * Get biom_ab
     *
     * @return string 
     */
    public function getBiomAb()
    {
        return  $this->biom_ab;
    }

    /**
     * Set biom_poids
     *
     * @param string $biomPoids
     * @return Biometrie
     */
    public function setBiomPoids($biomPoids)
    {
        if($biomPoids && !is_numeric($biomPoids)){
            $this->_errors['biomPoids'] = "Cette valeur est numérique !";
        }
        else{
            if($biomPoids > 1000){
                $this->_errors['biomPoids'] = "Poids improbable";
            }
            $this->biom_poids = $biomPoids;
        }

        return $this;
    }

    /**
     * Get biom_poids
     *
     * @return string 
     */
    public function getBiomPoids()
    {
        return  $this->biom_poids;
    }

    /**
     * Set biom_d3mf1
     *
     * @param string $biomD3mf1
     * @return Biometrie
     */
    public function setBiomD3mf1($biomD3mf1)
    {
        if($biomD3mf1 && !is_numeric($biomD3mf1)){
            $this->_errors['biomD3mf1'] = "Cette valeur est numérique !";
        }
        else $this->biom_d3mf1 = $biomD3mf1;

        return $this;
    }

    /**
     * Get biom_d3mf1
     *
     * @return string 
     */
    public function getBiomD3mf1()
    {
        return  $this->biom_d3mf1;
    }

    /**
     * Set biom_d3f2f3
     *
     * @param string $biomD3f2f3
     * @return Biometrie
     */
    public function setBiomD3f2f3($biomD3f2f3)
    {
        if($biomD3f2f3 && !is_numeric($biomD3f2f3)){
            $this->_errors['biomD3f2f3'] = "Cette valeur est numérique !";
        }
        else $this->biom_d3f2f3 = $biomD3f2f3;

        return $this;
    }

    /**
     * Get biom_d3f2f3
     *
     * @return string 
     */
    public function getBiomD3f2f3()
    {
        return  $this->biom_d3f2f3;
    }

    /**
     * Set biom_d3total
     *
     * @param string $biomD3total
     * @return Biometrie
     */
    public function setBiomD3total($biomD3total)
    {
        if($biomD3total && !is_numeric($biomD3total)){
            $this->_errors['biomD3total'] = "Cette valeur est numérique !";
        }
        else $this->biom_d3total = $biomD3total;

        return $this;
    }

    /**
     * Get biom_d3total
     *
     * @return string 
     */
    public function getBiomD3total()
    {
        return  $this->biom_d3total;
    }

    /**
     * Set biom_d5
     *
     * @param string $biomD5
     * @return Biometrie
     */
    public function setBiomD5($biomD5)
    {
        if($biomD5 && !is_numeric($biomD5)){
            $this->_errors['biomD5'] = "Cette valeur est numérique !";
        }
        else $this->biom_d5 = $biomD5;

        return $this;
    }

    /**
     * Get biom_d5
     *
     * @return string 
     */
    public function getBiomD5()
    {
        return  $this->biom_d5;
    }

    /**
     * Set biom_cm3sup
     *
     * @param string $biomCm3sup
     * @return Biometrie
     */
    public function setBiomCm3sup($biomCm3sup)
    {
        if($biomCm3sup && !is_numeric($biomCm3sup)){
            $this->_errors['biomCm3sup'] = "Cette valeur est numérique !";
        }
        else $this->biom_cm3sup = $biomCm3sup;

        return $this;
    }

    /**
     * Get biom_cm3sup
     *
     * @return string 
     */
    public function getBiomCm3sup()
    {
        return  $this->biom_cm3sup;
    }

    /**
     * Set biom_cm3inf
     *
     * @param string $biomCm3inf
     * @return Biometrie
     */
    public function setBiomCm3inf($biomCm3inf)
    {
        if($biomCm3inf && !is_numeric($biomCm3inf)){
            $this->_errors['biomCm3inf'] = "Cette valeur est numérique !";
        }
        else $this->biom_cm3inf = $biomCm3inf;

        return $this;
    }

    /**
     * Get biom_cm3inf
     *
     * @return string 
     */
    public function getBiomCm3inf()
    {
        return  $this->biom_cm3inf;
    }

    /**
     * Set biom_cb
     *
     * @param string $biomCb
     * @return Biometrie
     */
    public function setBiomCb($biomCb)
    {
        if($biomCb && !is_numeric($biomCb)){
            $this->_errors['biomCb'] = "Cette valeur est numérique !";
        }
        else $this->biom_cb = $biomCb;

        return $this;
    }

    /**
     * Get biom_cb
     *
     * @return string 
     */
    public function getBiomCb()
    {
        return  $this->biom_cb;
    }

    /**
     * Set biom_lm
     *
     * @param string $biomLm
     * @return Biometrie
     */
    public function setBiomLm($biomLm)
    {
        if($biomLm && !is_numeric($biomLm)){
            $this->_errors['biomLm'] = "Cette valeur est numérique !";
        }
        else $this->biom_lm = $biomLm;

        return $this;
    }

    /**
     * Get biom_lm
     *
     * @return string 
     */
    public function getBiomLm()
    {
        return  $this->biom_lm;
    }

    /**
     * Set biom_oreille
     *
     * @param string $biomOreille
     * @return Biometrie
     */
    public function setBiomOreille($biomOreille)
    {
        if($biomOreille && !is_numeric($biomOreille)){
            $this->_errors['biomOreille'] = "Cette valeur est numérique !";
        }
        else $this->biom_oreille = $biomOreille;

        return $this;
    }

    /**
     * Get biom_oreille
     *
     * @return string 
     */
    public function getBiomOreille()
    {
        return  $this->biom_oreille;
    }

    /**
     * Set biom_commentaire
     *
     * @param string $biomCommentaire
     * @return Biometrie
     */
    public function setBiomCommentaire($biomCommentaire)
    {
        $this->biom_commentaire = $biomCommentaire;

        return $this;
    }

    /**
     * Get biom_commentaire
     *
     * @return string 
     */
    public function getBiomCommentaire()
    {
        return $this->biom_commentaire;
    }
    /**
     * @var integer
     */
    private $id;


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
     * @var integer
     */
    private $obs_tx_id;

    /**
     * @var \PNC\ChiroBundle\Entity\ObservationTaxon
     */
    private $observation;


    /**
     * Set obs_tx_id
     *
     * @param integer $obsTxId
     * @return Biometrie
     */
    public function setObsTxId($obsTxId)
    {
        $this->obs_tx_id = $obsTxId;

        return $this;
    }

    /**
     * Get obs_tx_id
     *
     * @return integer 
     */
    public function getObsTxId()
    {
        return $this->obs_tx_id;
    }

    /**
     * Set observation
     *
     * @param \PNC\ChiroBundle\Entity\ObservationTaxon $observation
     * @return Biometrie
     */
    public function setObservation(\PNC\ChiroBundle\Entity\ObservationTaxon $observation = null)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return \PNC\ChiroBundle\Entity\ObservationTaxon 
     */
    public function getObservation()
    {
        return $this->observation;
    }
    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Biometrie
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Biometrie
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    /**
     * @var integer
     */
    private $numerisateur_id;


    /**
     * Set numerisateur_id
     *
     * @param integer $numerisateurId
     * @return Biometrie
     */
    public function setNumerisateurId($numerisateurId)
    {
        $this->numerisateur_id = $numerisateurId;

        return $this;
    }

    /**
     * Get numerisateur_id
     *
     * @return integer 
     */
    public function getNumerisateurId()
    {
        return $this->numerisateur_id;
    }
}
