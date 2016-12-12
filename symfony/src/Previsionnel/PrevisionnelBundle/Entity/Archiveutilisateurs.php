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
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=false)
     */
    private $idutilisateur;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

    /**
     * @var string
     *
     * @ORM\Column(name="idRole", type="text", length=65535, nullable=false)
     */
    private $idrole;

    /**
     * @var float
     *
     * @ORM\Column(name="decharge", type="float", precision=10, scale=0, nullable=false)
     */
    private $decharge;

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
     * Set idrole
     *
     * @param string $idrole
     *
     * @return Archiveutilisateurs
     */
    public function setIdrole($idrole)
    {
        $this->idrole = $idrole;

        return $this;
    }

    /**
     * Get idrole
     *
     * @return string
     */
    public function getIdrole()
    {
        return $this->idrole;
    }

    /**
     * Set decharge
     *
     * @param float $decharge
     *
     * @return Archiveutilisateurs
     */
    public function setDecharge($decharge)
    {
        $this->decharge = $decharge;

        return $this;
    }

    /**
     * Get decharge
     *
     * @return float
     */
    public function getDecharge()
    {
        return $this->decharge;
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
