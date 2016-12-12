<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity
 */
class Cours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUE", type="integer", nullable=false)
     */
    private $idue;

    /**
     * @var integer
     *
     * @ORM\Column(name="idTypeCours", type="integer", nullable=false)
     */
    private $idtypecours;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=9, nullable=false)
     */
    private $annee;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set idue
     *
     * @param integer $idue
     *
     * @return Cours
     */
    public function setIdue($idue)
    {
        $this->idue = $idue;

        return $this;
    }

    /**
     * Get idue
     *
     * @return integer
     */
    public function getIdue()
    {
        return $this->idue;
    }

    /**
     * Set idtypecours
     *
     * @param integer $idtypecours
     *
     * @return Cours
     */
    public function setIdtypecours($idtypecours)
    {
        $this->idtypecours = $idtypecours;

        return $this;
    }

    /**
     * Get idtypecours
     *
     * @return integer
     */
    public function getIdtypecours()
    {
        return $this->idtypecours;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return Cours
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
