<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heuresaffectees
 *
 * @ORM\Table(name="heuresaffectees")
 * @ORM\Entity
 */
class Heuresaffectees
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUtilisateur", type="integer", nullable=false)
     */
    private $idutilisateur;

    /**
     * @var integer
     *
     * @ORM\Column(name="idCours", type="integer", nullable=false)
     */
    private $idcours;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatut", type="integer", nullable=false)
     */
    private $idstatut;

    /**
     * @var float
     *
     * @ORM\Column(name="nbHeures", type="float", precision=10, scale=0, nullable=false)
     */
    private $nbheures;

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
     * Set idutilisateur
     *
     * @param integer $idutilisateur
     *
     * @return Heuresaffectees
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
     * Set idcours
     *
     * @param integer $idcours
     *
     * @return Heuresaffectees
     */
    public function setIdcours($idcours)
    {
        $this->idcours = $idcours;

        return $this;
    }

    /**
     * Get idcours
     *
     * @return integer
     */
    public function getIdcours()
    {
        return $this->idcours;
    }

    /**
     * Set idstatut
     *
     * @param integer $idstatut
     *
     * @return Heuresaffectees
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
     * Set nbheures
     *
     * @param float $nbheures
     *
     * @return Heuresaffectees
     */
    public function setNbheures($nbheures)
    {
        $this->nbheures = $nbheures;

        return $this;
    }

    /**
     * Get nbheures
     *
     * @return float
     */
    public function getNbheures()
    {
        return $this->nbheures;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return Heuresaffectees
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
