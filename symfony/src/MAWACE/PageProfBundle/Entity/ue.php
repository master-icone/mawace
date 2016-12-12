<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ue
 *
 * @ORM\Table(name="ue")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\ueRepository")
 */
class ue
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
     * @ORM\Column(name="idDepartement", type="integer")
     */
    private $idDepartement;

    /**
     * @var string
     *
     * @ORM\Column(name="annee", type="string", length=9)
     */
    private $annee;


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
     * @return ue
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
     * Set idDepartement
     *
     * @param integer $idDepartement
     *
     * @return ue
     */
    public function setIdDepartement($idDepartement)
    {
        $this->idDepartement = $idDepartement;

        return $this;
    }

    /**
     * Get idDepartement
     *
     * @return int
     */
    public function getIdDepartement()
    {
        return $this->idDepartement;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return ue
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
}

