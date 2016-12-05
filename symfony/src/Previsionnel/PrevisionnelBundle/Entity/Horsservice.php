<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horsservice
 *
 * @ORM\Table(name="horsservice")
 * @ORM\Entity
 */
class Horsservice
{
    /**
     * @var float
     *
     * @ORM\Column(name="coeffCM", type="float", precision=10, scale=0, nullable=false)
     */
    private $coeffcm;

    /**
     * @var float
     *
     * @ORM\Column(name="coeffTD", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefftd;

    /**
     * @var float
     *
     * @ORM\Column(name="coeffTP", type="float", precision=10, scale=0, nullable=false)
     */
    private $coefftp;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set coeffcm
     *
     * @param float $coeffcm
     *
     * @return Horsservice
     */
    public function setCoeffcm($coeffcm)
    {
        $this->coeffcm = $coeffcm;

        return $this;
    }

    /**
     * Get coeffcm
     *
     * @return float
     */
    public function getCoeffcm()
    {
        return $this->coeffcm;
    }

    /**
     * Set coefftd
     *
     * @param float $coefftd
     *
     * @return Horsservice
     */
    public function setCoefftd($coefftd)
    {
        $this->coefftd = $coefftd;

        return $this;
    }

    /**
     * Get coefftd
     *
     * @return float
     */
    public function getCoefftd()
    {
        return $this->coefftd;
    }

    /**
     * Set coefftp
     *
     * @param float $coefftp
     *
     * @return Horsservice
     */
    public function setCoefftp($coefftp)
    {
        $this->coefftp = $coefftp;

        return $this;
    }

    /**
     * Get coefftp
     *
     * @return float
     */
    public function getCoefftp()
    {
        return $this->coefftp;
    }

    /**
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Horsservice
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
