<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Interdictionaffectation
 *
 * @ORM\Table(name="interdictionaffectation")
 * @ORM\Entity
 */
class Interdictionaffectation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idTypeCours", type="integer", nullable=false)
     */
    private $idtypecours;

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
     * Set idtypecours
     *
     * @param integer $idtypecours
     *
     * @return Interdictionaffectation
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
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Interdictionaffectation
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
