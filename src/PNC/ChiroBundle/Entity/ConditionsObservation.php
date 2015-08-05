<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * ConditionsObservation
 */
class ConditionsObservation extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fk_bv_id;

    /**
     * @var float
     */
    private $cvc_temperature;

    /**
     * @var float
     */
    private $cvc_humidite;

    /**
     * @var integer
     */
    private $cvc_mod_id;


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
     * Set fk_bv_id
     *
     * @param integer $fkBvId
     * @return ConditionsObservation
     */
    public function setFkBvId($fkBvId)
    {
        $this->fk_bv_id = $fkBvId;

        return $this;
    }

    /**
     * Get fk_bv_id
     *
     * @return integer 
     */
    public function getFkBvId()
    {
        return $this->fk_bv_id;
    }

    /**
     * Set cvc_temperature
     *
     * @param float $cvcTemperature
     * @return ConditionsObservation
     */
    public function setCvcTemperature($cvcTemperature)
    {
        $this->cvc_temperature = $cvcTemperature;

        return $this;
    }

    /**
     * Get cvc_temperature
     *
     * @return float 
     */
    public function getCvcTemperature()
    {
        return $this->cvc_temperature;
    }

    /**
     * Set cvc_humidite
     *
     * @param float $cvcHumidite
     * @return ConditionsObservation
     */
    public function setCvcHumidite($cvcHumidite)
    {
        $this->cvc_humidite = $cvcHumidite;

        return $this;
    }

    /**
     * Get cvc_humidite
     *
     * @return float 
     */
    public function getCvcHumidite()
    {
        return $this->cvc_humidite;
    }

    /**
     * Set cvc_mod_id
     *
     * @param integer $cvcModId
     * @return ConditionsObservation
     */
    public function setCvcModId($cvcModId)
    {
        $this->cvc_mod_id = $cvcModId;

        return $this;
    }

    /**
     * Get cvc_mod_id
     *
     * @return integer 
     */
    public function getCvcModId()
    {
        return $this->cvc_mod_id;
    }
}
