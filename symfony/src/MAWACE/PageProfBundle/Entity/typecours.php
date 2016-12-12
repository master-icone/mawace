<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * typecours
 *
 * @ORM\Table(name="typecours")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\typecoursRepository")
 */
class typecours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="methodeEnseignement", type="string", length=255)
     */
    private $methodeEnseignement;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return typecours
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
     * Set methodeEnseignement
     *
     * @param string $methodeEnseignement
     *
     * @return typecours
     */
    public function setMethodeEnseignement($methodeEnseignement)
    {
        $this->methodeEnseignement = $methodeEnseignement;

        return $this;
    }

    /**
     * Get methodeEnseignement
     *
     * @return string
     */
    public function getMethodeEnseignement()
    {
        return $this->methodeEnseignement;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return typecours
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
}

