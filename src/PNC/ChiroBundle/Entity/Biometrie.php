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
    private $id;

    /**
     * @var integer
     */
    private $fk_cotx_id;

    /**
     * @var integer
     */
    private $cbio_age_id;

    /**
     * @var integer
     */
    private $cbio_sexe_id;

    /**
     * @var float
     */
    private $cbio_ab;

    /**
     * @var float
     */
    private $cbio_poids;

    /**
     * @var float
     */
    private $cbio_d3mf1;

    /**
     * @var float
     */
    private $cbio_d3f2f3;

    /**
     * @var float
     */
    private $cbio_d3total;

    /**
     * @var float
     */
    private $cbio_d5;

    /**
     * @var float
     */
    private $cbio_cm3sup;

    /**
     * @var float
     */
    private $cbio_cm3inf;

    /**
     * @var float
     */
    private $cbio_cb;

    /**
     * @var float
     */
    private $cbio_lm;

    /**
     * @var float
     */
    private $cbio_oreille;

    /**
     * @var string
     */
    private $cbio_commentaire;

    /**
     * @var \DateTime
     */
    private $meta_create_timestamp;

    /**
     * @var \DateTime
     */
    private $meta_update_timestamp;

    /**
     * @var integer
     */
    private $meta_numerisateur_id;


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
     * Set fk_cotx_id
     *
     * @param integer $fkCotxId
     * @return Biometrie
     */
    public function setFkCotxId($fkCotxId)
    {
        $this->fk_cotx_id = $fkCotxId;

        return $this;
    }

    /**
     * Get fk_cotx_id
     *
     * @return integer 
     */
    public function getFkCotxId()
    {
        return $this->fk_cotx_id;
    }

    /**
     * Set cbio_age_id
     *
     * @param integer $cbioAgeId
     * @return Biometrie
     */
    public function setCbioAgeId($cbioAgeId)
    {
        $this->cbio_age_id = $cbioAgeId;

        return $this;
    }

    /**
     * Get cbio_age_id
     *
     * @return integer 
     */
    public function getCbioAgeId()
    {
        return $this->cbio_age_id;
    }

    /**
     * Set cbio_sexe_id
     *
     * @param integer $cbioSexeId
     * @return Biometrie
     */
    public function setCbioSexeId($cbioSexeId)
    {
        $this->cbio_sexe_id = $cbioSexeId;

        return $this;
    }

    /**
     * Get cbio_sexe_id
     *
     * @return integer 
     */
    public function getCbioSexeId()
    {
        return $this->cbio_sexe_id;
    }

    /**
     * Set cbio_ab
     *
     * @param float $cbioAb
     * @return Biometrie
     */
    public function setCbioAb($cbioAb)
    {
        $this->cbio_ab = $cbioAb;

        return $this;
    }

    /**
     * Get cbio_ab
     *
     * @return float 
     */
    public function getCbioAb()
    {
        return $this->cbio_ab;
    }

    /**
     * Set cbio_poids
     *
     * @param float $cbioPoids
     * @return Biometrie
     */
    public function setCbioPoids($cbioPoids)
    {
        $this->cbio_poids = $cbioPoids;

        return $this;
    }

    /**
     * Get cbio_poids
     *
     * @return float 
     */
    public function getCbioPoids()
    {
        return $this->cbio_poids;
    }

    /**
     * Set cbio_d3mf1
     *
     * @param float $cbioD3mf1
     * @return Biometrie
     */
    public function setCbioD3mf1($cbioD3mf1)
    {
        $this->cbio_d3mf1 = $cbioD3mf1;

        return $this;
    }

    /**
     * Get cbio_d3mf1
     *
     * @return float 
     */
    public function getCbioD3mf1()
    {
        return $this->cbio_d3mf1;
    }

    /**
     * Set cbio_d3f2f3
     *
     * @param float $cbioD3f2f3
     * @return Biometrie
     */
    public function setCbioD3f2f3($cbioD3f2f3)
    {
        $this->cbio_d3f2f3 = $cbioD3f2f3;

        return $this;
    }

    /**
     * Get cbio_d3f2f3
     *
     * @return float 
     */
    public function getCbioD3f2f3()
    {
        return $this->cbio_d3f2f3;
    }

    /**
     * Set cbio_d3total
     *
     * @param float $cbioD3total
     * @return Biometrie
     */
    public function setCbioD3total($cbioD3total)
    {
        $this->cbio_d3total = $cbioD3total;

        return $this;
    }

    /**
     * Get cbio_d3total
     *
     * @return float 
     */
    public function getCbioD3total()
    {
        return $this->cbio_d3total;
    }

    /**
     * Set cbio_d5
     *
     * @param float $cbioD5
     * @return Biometrie
     */
    public function setCbioD5($cbioD5)
    {
        $this->cbio_d5 = $cbioD5;

        return $this;
    }

    /**
     * Get cbio_d5
     *
     * @return float 
     */
    public function getCbioD5()
    {
        return $this->cbio_d5;
    }

    /**
     * Set cbio_cm3sup
     *
     * @param float $cbioCm3sup
     * @return Biometrie
     */
    public function setCbioCm3sup($cbioCm3sup)
    {
        $this->cbio_cm3sup = $cbioCm3sup;

        return $this;
    }

    /**
     * Get cbio_cm3sup
     *
     * @return float 
     */
    public function getCbioCm3sup()
    {
        return $this->cbio_cm3sup;
    }

    /**
     * Set cbio_cm3inf
     *
     * @param float $cbioCm3inf
     * @return Biometrie
     */
    public function setCbioCm3inf($cbioCm3inf)
    {
        $this->cbio_cm3inf = $cbioCm3inf;

        return $this;
    }

    /**
     * Get cbio_cm3inf
     *
     * @return float 
     */
    public function getCbioCm3inf()
    {
        return $this->cbio_cm3inf;
    }

    /**
     * Set cbio_cb
     *
     * @param float $cbioCb
     * @return Biometrie
     */
    public function setCbioCb($cbioCb)
    {
        $this->cbio_cb = $cbioCb;

        return $this;
    }

    /**
     * Get cbio_cb
     *
     * @return float 
     */
    public function getCbioCb()
    {
        return $this->cbio_cb;
    }

    /**
     * Set cbio_lm
     *
     * @param float $cbioLm
     * @return Biometrie
     */
    public function setCbioLm($cbioLm)
    {
        $this->cbio_lm = $cbioLm;

        return $this;
    }

    /**
     * Get cbio_lm
     *
     * @return float 
     */
    public function getCbioLm()
    {
        return $this->cbio_lm;
    }

    /**
     * Set cbio_oreille
     *
     * @param float $cbioOreille
     * @return Biometrie
     */
    public function setCbioOreille($cbioOreille)
    {
        $this->cbio_oreille = $cbioOreille;

        return $this;
    }

    /**
     * Get cbio_oreille
     *
     * @return float 
     */
    public function getCbioOreille()
    {
        return $this->cbio_oreille;
    }

    /**
     * Set cbio_commentaire
     *
     * @param string $cbioCommentaire
     * @return Biometrie
     */
    public function setCbioCommentaire($cbioCommentaire)
    {
        $this->cbio_commentaire = $cbioCommentaire;

        return $this;
    }

    /**
     * Get cbio_commentaire
     *
     * @return string 
     */
    public function getCbioCommentaire()
    {
        return $this->cbio_commentaire;
    }

    /**
     * Set meta_create_timestamp
     *
     * @param \DateTime $metaCreateTimestamp
     * @return Biometrie
     */
    public function setMetaCreateTimestamp($metaCreateTimestamp)
    {
        $this->meta_create_timestamp = $metaCreateTimestamp;

        return $this;
    }

    /**
     * Get meta_create_timestamp
     *
     * @return \DateTime 
     */
    public function getMetaCreateTimestamp()
    {
        return $this->meta_create_timestamp;
    }

    /**
     * Set meta_update_timestamp
     *
     * @param \DateTime $metaUpdateTimestamp
     * @return Biometrie
     */
    public function setMetaUpdateTimestamp($metaUpdateTimestamp)
    {
        $this->meta_update_timestamp = $metaUpdateTimestamp;

        return $this;
    }

    /**
     * Get meta_update_timestamp
     *
     * @return \DateTime 
     */
    public function getMetaUpdateTimestamp()
    {
        return $this->meta_update_timestamp;
    }

    /**
     * Set meta_numerisateur_id
     *
     * @param integer $metaNumerisateurId
     * @return Biometrie
     */
    public function setMetaNumerisateurId($metaNumerisateurId)
    {
        $this->meta_numerisateur_id = $metaNumerisateurId;

        return $this;
    }

    /**
     * Get meta_numerisateur_id
     *
     * @return integer 
     */
    public function getMetaNumerisateurId()
    {
        return $this->meta_numerisateur_id;
    }
}
