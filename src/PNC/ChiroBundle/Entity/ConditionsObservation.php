<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConditionsObservation
 */
class ConditionsObservation
{

    private $_errors = array();
    
    /*
     * Retourne la liste des champs invalides s'il y en a
     * ou false si tout est OK
     */

    public function errors(){
        /*if(empty($this->_errors)){
            return false;
        }*/
        return $this->_errors;
    }

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $obs_temperature;

    /**
     * @var string
     */
    private $obs_humidite;

    private $mod_id;


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
     * Set obs_temperature
     *
     * @param string $obsTemperature
     * @return ConditionsObservation
     */
    public function setObsTemperature($obsTemperature)
    {
        $this->obs_temperature = $obsTemperature;

        return $this;
    }

    /**
     * Get obs_temperature
     *
     * @return string 
     */
    public function getObsTemperature()
    {
        return  $this->obs_temperature;
    }

    /**
     * Set obs_humidite
     *
     * @param string $obsHumidite
     * @return ConditionsObservation
     */
    public function setObsHumidite($obsHumidite)
    {
        $this->obs_humidite = $obsHumidite;

        return $this;
    }

    /**
     * Get obs_humidite
     *
     * @return string 
     */
    public function getObsHumidite()
    {
        return  $this->obs_humidite;
    }

    /**
     * @var integer
     */
    private $obs_id;


    /**
     * Set obs_id
     *
     * @param integer $obsId
     * @return ConditionsObservation
     */
    public function setObsId($obsId)
    {
        $this->obs_id = $obsId;

        return $this;
    }

    /**
     * Get obs_id
     *
     * @return integer 
     */
    public function getObsId()
    {
        return $this->obs_id;
    }

    public function setModId($mod_id){
        $this->mod_id = $mod_id;
    }

    public function getModId(){
        return $this->mod_id;
    }

}
