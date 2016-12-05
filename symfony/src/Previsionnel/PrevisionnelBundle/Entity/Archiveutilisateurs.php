<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Archiveutilisateurs
 *
 * @ORM\Table(name="archiveutilisateurs")
 * @ORM\Entity
 */
class Archiveutilisateurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idDepartement", type="integer", nullable=false)
     */
    private $iddepartement;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=false)
     */
    private $idutilisateur;

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
     * Set iddepartement
     *
     * @param integer $iddepartement
     *
     * @return Archiveutilisateurs
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
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Archiveutilisateurs
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
     * Set idutilisateur
     *
     * @param integer $idutilisateur
     *
     * @return Archiveutilisateurs
     */
    public function setIdutilisateur($idutilisateur)
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    /**
     * Get idutilisateur
     *
     * @return integer
     */
    public function getIdutilisateur()
    {
        return $this->idutilisateur;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return Archiveutilisateurs
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
