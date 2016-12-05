<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typecours
 *
 * @ORM\Table(name="typecours")
 * @ORM\Entity
 */
class Typecours
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="methodeEnseignement", type="string", length=255, nullable=false)
     */
    private $methodeenseignement;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

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
     * @return Typecours
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
     * Set methodeenseignement
     *
     * @param string $methodeenseignement
     *
     * @return Typecours
     */
    public function setMethodeenseignement($methodeenseignement)
    {
        $this->methodeenseignement = $methodeenseignement;

        return $this;
    }

    /**
     * Get methodeenseignement
     *
     * @return string
     */
    public function getMethodeenseignement()
    {
        return $this->methodeenseignement;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Typecours
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
