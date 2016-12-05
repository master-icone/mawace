<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * statut
 *
 * @ORM\Table(name="statut")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\statutRepository")
 */
class statut
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
     * @var int
     *
     * @ORM\Column(name="decharge", type="integer")
     */
    private $decharge;


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
     * @return statut
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
     * @return statut
     */
    public function setDecharge($decharge)
    {
        $this->decharge = $decharge;

        return $this;
    }

    /**
     * Get decharge
     *
     * @return int
     */
    public function getDecharge()
    {
        return $this->decharge;
    }
}

