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
     * @var decimal
     *
     * @ORM\Column(name="potentielBrut", type="decimal")
     */
    private $potentielBrut;

	/**
     * @var text
     *
     * @ORM\Column(name="ordreCours", type="text")
     */
    private $ordreCours;
	
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
     * Set potentielBrut
     *
     * @param decimal $potentielBrut
     *
     * @return statut
     */
    public function setPotentielBrut($potentielbrut)
    {
        $this->potentielBrut = $potentielbrut;

        return $this;
    }

    /**
     * Get potentielBrut
     *
     * @return decimal
     */
    public function getPotentielBrut()
    {
        return $this->potentielBrut;
    }
	
	/**
     * Set ordreCours
     *
     * @param text $ordreCours
     *
     * @return statut
     */
    public function setOrdreCours($ordrecours)
    {
        $this->ordreCours = $ordrecours;

        return $this;
    }

    /**
     * Get ordreCours
     *
     * @return text
     */
    public function getOrdreCours()
    {
        return $this->ordreCours;
    }
}


