<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Limitenbcours
 *
 * @ORM\Table(name="limitenbcours")
 * @ORM\Entity
 */
class Limitenbcours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

    /**
     * @var integer
     *
     * @ORM\Column(name="idTypeCours", type="integer", nullable=false)
     */
    private $idtypecours;

    /**
     * @var float
     *
     * @ORM\Column(name="nbHeures", type="float", precision=10, scale=0, nullable=false)
     */
    private $nbheures;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Limitenbcours
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
     * Set idtypecours
     *
     * @param integer $idtypecours
     *
     * @return Limitenbcours
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
     * Set nbheures
     *
     * @param float $nbheures
     *
     * @return Limitenbcours
     */
    public function setNbheures($nbheures)
    {
        $this->nbheures = $nbheures;

        return $this;
    }

    /**
     * Get nbheures
     *
     * @return float
     */
    public function getNbheures()
    {
        return $this->nbheures;
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
