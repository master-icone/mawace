<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * archiveutilisateurs
 *
 * @ORM\Table(name="archiveutilisateurs")
 * @ORM\Entity
 */
class archiveutilisateurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idDepartement", type="integer", nullable=false)
     */
    private $idDepartement;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=false)
     */
    private $idUtilisateur;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idStatut;
	
	/**
     * @var text
     *
     * @ORM\Column(name="idRole", type="text", nullable=false)
     */
    private $idRole;

	/**
     * @var decimal
     *
     * @ORM\Column(name="decharge", type="decimal", nullable=false)
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
    public function setIdDepartement($iddepartement)
    {
        $this->idDepartement = $iddepartement;

        return $this;
    }

    /**
     * Get iddepartement
     *
     * @return integer
     */
    public function getIdDepartement()
    {
        return $this->idDepartement;
    }

    /**
     * Set idutilisateur
     *
     * @param integer $idutilisateur
     *
     * @return Archiveutilisateurs
     */
    public function setIdUtilisateur($idutilisateur)
    {
        $this->idUtilisateur = $idutilisateur;

        return $this;
    }

    /**
     * Get idutilisateur
     *
     * @return integer
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }
	
	/**
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Archiveutilisateurs
     */
    public function setIdStatut($idstatut)
    {
        $this->idStatut = $idstatut;

        return $this;
    }

    /**
     * Get idstatut
     *
     * @return integer
     */
    public function getIdStatut()
    {
        return $this->idStatut;
    }
	
	/**
     * Set idrole
     *
     * @param text $idrole
     *
     * @return archiveutilisateurs
     */
    public function setIdRole($idrole)
    {
        $this->idRole = $idrole;

        return $this;
    }

    /**
     * Get idrole
     *
     * @return text
     */
    public function getIdRole()
    {
        return $this->idRole;
    }
	
	/**
     * Set decharge
     *
     * @param decimal $decharge
     *
     * @return archiveutilisateurs
     */
    public function setDecharge($decharge)
    {
        $this->decharge = $decharge;

        return $this;
    }

    /**
     * Get decharge
     *
     * @return decimal
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
