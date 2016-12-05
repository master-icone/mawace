<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ue
 *
 * @ORM\Table(name="ue")
 * @ORM\Entity
 */
class Ue
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
     * @ORM\Column(name="idDepartement", type="integer", nullable=false)
     */
    private $iddepartement;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Ue
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
     * Set iddepartement
     *
     * @param integer $iddepartement
     *
     * @return Ue
     */
    public function setIddepartement($iddepartement)
    {
        $this->iddepartement = $iddepartement;

        return $this;
    }

    /**
     * Get iddepartement
     *
     * @return integer
     */
    public function getIddepartement()
    {
        return $this->iddepartement;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return Ue
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
