<?php

namespace PNC\ChiroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PNC\Utils\BaseEntity;

/**
 * InfoSite
 */
class InfoSite extends BaseEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fk_bs_id;

    /**
     * @var integer
     */
    private $cis_frequentation;

    /**
     * @var integer
     */
    private $cis_menace;

    /**
     * @var string
     */
    private $cis_menace_cmt;

    /**
     * @var string
     */
    private $cis_contact_nom;

    /**
     * @var string
     */
    private $cis_contact_prenom;

    /**
     * @var string
     */
    private $cis_contact_adresse;

    /**
     * @var string
     */
    private $cis_contact_code_postal;

    /**
     * @var string
     */
    private $cis_contact_ville;

    /**
     * @var string
     */
    private $cis_contact_telephone;

    /**
     * @var string
     */
    private $cis_contact_portable;

    /**
     * @var string
     */
    private $cis_contact_commentaire;

    /**
     * @var string
     */
    private $cis_actions;

    /**
     * @var boolean
     */
    private $cis_site_actif;

    /**
     * @var \PNC\BaseAppBundle\Entity\Site
     */
    private $parent_site;


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
     * Set fk_bs_id
     *
     * @param integer $fkBsId
     * @return InfoSite
     */
    public function setFkBsId($fkBsId)
    {
        $this->fk_bs_id = $fkBsId;

        return $this;
    }

    /**
     * Get fk_bs_id
     *
     * @return integer 
     */
    public function getFkBsId()
    {
        return $this->fk_bs_id;
    }

    /**
     * Set cis_frequentation
     *
     * @param integer $cisFrequentation
     * @return InfoSite
     */
    public function setCisFrequentation($cisFrequentation)
    {
        $this->cis_frequentation = $cisFrequentation;

        return $this;
    }

    /**
     * Get cis_frequentation
     *
     * @return integer 
     */
    public function getCisFrequentation()
    {
        return $this->cis_frequentation;
    }

    /**
     * Set cis_menace
     *
     * @param integer $cisMenace
     * @return InfoSite
     */
    public function setCisMenace($cisMenace)
    {
        $this->cis_menace = $cisMenace;

        return $this;
    }

    /**
     * Get cis_menace
     *
     * @return integer 
     */
    public function getCisMenace()
    {
        return $this->cis_menace;
    }

    /**
     * Set cis_menace_cmt
     *
     * @param string $cisMenaceCmt
     * @return InfoSite
     */
    public function setCisMenaceCmt($cisMenaceCmt)
    {
        $this->cis_menace_cmt = $cisMenaceCmt;

        return $this;
    }

    /**
     * Get cis_menace_cmt
     *
     * @return string 
     */
    public function getCisMenaceCmt()
    {
        return $this->cis_menace_cmt;
    }

    /**
     * Set cis_contact_nom
     *
     * @param string $cisContactNom
     * @return InfoSite
     */
    public function setCisContactNom($cisContactNom)
    {
        $this->cis_contact_nom = $cisContactNom;

        return $this;
    }

    /**
     * Get cis_contact_nom
     *
     * @return string 
     */
    public function getCisContactNom()
    {
        return $this->cis_contact_nom;
    }

    /**
     * Set cis_contact_prenom
     *
     * @param string $cisContactPrenom
     * @return InfoSite
     */
    public function setCisContactPrenom($cisContactPrenom)
    {
        $this->cis_contact_prenom = $cisContactPrenom;

        return $this;
    }

    /**
     * Get cis_contact_prenom
     *
     * @return string 
     */
    public function getCisContactPrenom()
    {
        return $this->cis_contact_prenom;
    }

    /**
     * Set cis_contact_adresse
     *
     * @param string $cisContactAdresse
     * @return InfoSite
     */
    public function setCisContactAdresse($cisContactAdresse)
    {
        $this->cis_contact_adresse = $cisContactAdresse;

        return $this;
    }

    /**
     * Get cis_contact_adresse
     *
     * @return string 
     */
    public function getCisContactAdresse()
    {
        return $this->cis_contact_adresse;
    }

    /**
     * Set cis_contact_code_postal
     *
     * @param string $cisContactCodePostal
     * @return InfoSite
     */
    public function setCisContactCodePostal($cisContactCodePostal)
    {
        $this->cis_contact_code_postal = $cisContactCodePostal;

        return $this;
    }

    /**
     * Get cis_contact_code_postal
     *
     * @return string 
     */
    public function getCisContactCodePostal()
    {
        return $this->cis_contact_code_postal;
    }

    /**
     * Set cis_contact_ville
     *
     * @param string $cisContactVille
     * @return InfoSite
     */
    public function setCisContactVille($cisContactVille)
    {
        $this->cis_contact_ville = $cisContactVille;

        return $this;
    }

    /**
     * Get cis_contact_ville
     *
     * @return string 
     */
    public function getCisContactVille()
    {
        return $this->cis_contact_ville;
    }

    /**
     * Set cis_contact_telephone
     *
     * @param string $cisContactTelephone
     * @return InfoSite
     */
    public function setCisContactTelephone($cisContactTelephone)
    {
        $this->cis_contact_telephone = $cisContactTelephone;

        return $this;
    }

    /**
     * Get cis_contact_telephone
     *
     * @return string 
     */
    public function getCisContactTelephone()
    {
        return $this->cis_contact_telephone;
    }

    /**
     * Set cis_contact_portable
     *
     * @param string $cisContactPortable
     * @return InfoSite
     */
    public function setCisContactPortable($cisContactPortable)
    {
        $this->cis_contact_portable = $cisContactPortable;

        return $this;
    }

    /**
     * Get cis_contact_portable
     *
     * @return string 
     */
    public function getCisContactPortable()
    {
        return $this->cis_contact_portable;
    }

    /**
     * Set cis_contact_commentaire
     *
     * @param string $cisContactCommentaire
     * @return InfoSite
     */
    public function setCisContactCommentaire($cisContactCommentaire)
    {
        $this->cis_contact_commentaire = $cisContactCommentaire;

        return $this;
    }

    /**
     * Get cis_contact_commentaire
     *
     * @return string 
     */
    public function getCisContactCommentaire()
    {
        return $this->cis_contact_commentaire;
    }

    /**
     * Set cis_site_actif
     *
     * @param boolean $cisSiteActif
     * @return InfoSite
     */
    public function setCisSiteActif($cisSiteActif)
    {
        $this->cis_site_actif = $cisSiteActif;

        return $this;
    }

    /**
     * Get cis_site_actif
     *
     * @return boolean 
     */
    public function getCisSiteActif()
    {
        return $this->cis_site_actif;
    }

    /**
     * Set parent_site
     *
     * @param \PNC\BaseAppBundle\Entity\Site $parentSite
     * @return InfoSite
     */
    public function setParentSite(\PNC\BaseAppBundle\Entity\Site $parentSite = null)
    {
        $this->parent_site = $parentSite;

        return $this;
    }

    /**
     * Get parent_site
     *
     * @return \PNC\BaseAppBundle\Entity\Site 
     */
    public function getParentSite()
    {
        return $this->parent_site;
    }

    public function setCisActions($actions){
        $this->cis_actions = $actions;
        return $this;
    }

    public function getCisActions(){
        return $this->cis_actions;
    }
}
