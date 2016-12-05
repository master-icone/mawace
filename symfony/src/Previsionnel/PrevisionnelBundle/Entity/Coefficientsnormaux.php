<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coefficientsnormaux
 *
 * @ORM\Table(name="coefficientsnormaux")
 * @ORM\Entity
 */
class Coefficientsnormaux
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTypeCours", type="integer", nullable=false)
     */
    private $idtypecours;

    /**
     * @var float
     *
     * @ORM\Column(name="coeff", type="float", precision=10, scale=0, nullable=false)
     */
    private $coeff;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

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
     * Set idtypecours
     *
     * @param integer $idtypecours
     *
     * @return Coefficientsnormaux
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
     * Set coeff
     *
     * @param float $coeff
     *
     * @return Coefficientsnormaux
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;

        return $this;
    }

    /**
     * Get coeff
     *
     * @return float
     */
    public function getCoeff()
    {
        return $this->coeff;
    }

    /**
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Coefficientsnormaux
     */
    public function setIdstatut($idstatut)
    {
        $this->idstatut = $idstatut;

        return $this;
    }

    /**
     * Get idstatut
     *
     * @return integer
     */
    public function getIdstatut()
    {
        return $this->idstatut;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return Coefficientsnormaux
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
