<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statut
 *
 * @ORM\Table(name="statut")
 * @ORM\Entity
 */
class Statut
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="decharge", type="integer", nullable=false)
     */
    private $decharge;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Statut
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set decharge
     *
     * @param integer $decharge
     *
     * @return Statut
     */
    public function setDecharge($decharge)
    {
        $this->decharge = $decharge;

        return $this;
    }

    /**
     * Get decharge
     *
     * @return integer
     */
    public function getDecharge()
    {
        return $this->decharge;
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
