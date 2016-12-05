<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * heuresaffectees
 *
 * @ORM\Table(name="heuresaffectees")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\heuresaffecteesRepository")
 */
class heuresaffectees
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
     * @var int
     *
     * @ORM\Column(name="idUtilisateur", type="integer")
     */
    private $idUtilisateur;

    /**
     * @var int
     *
     * @ORM\Column(name="idCours", type="integer")
     */
    private $idCours;
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="idStatut", type="integer")
	 */
	private $idStatut;
    /**
     * @var string
     *
     * @ORM\Column(name="nbHeures", type="decimal", precision=2, scale=0)
     */
    private $nbHeures;

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
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return heuresaffectees
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return int
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set idCours
     *
     * @param integer $idCours
     *
     * @return heuresaffectees
     */
    public function setIdCours($idCours)
    {
        $this->idCours = $idCours;

        return $this;
    }

    /**
     * Get idCours
     *
     * @return int
     */
    public function getIdCours()
    {
        return $this->idCours;
    }

	/**
     * Set idStatut
     *
     * @param integer $idStatut
     *
     * @return heuresaffectees
     */
    public function setIdStatut($idStatut)
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    /**
     * Get idStatut
     *
     * @return int
     */
    public function getIdStatut()
    {
        return $this->idStatut;
    }
	
    /**
     * Set nbHeures
     *
     * @param string $nbHeures
     *
     * @return heuresaffectees
     */
    public function setNbHeures($nbHeures)
    {
        $this->nbHeures = $nbHeures;

        return $this;
    }

    /**
     * Get nbHeures
     *
     * @return string
     */
    public function getNbHeures()
    {
        return $this->nbHeures;
    }

    /**
     * Set annee
     *
     * @param string $annee
     *
     * @return heuresaffectees
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

