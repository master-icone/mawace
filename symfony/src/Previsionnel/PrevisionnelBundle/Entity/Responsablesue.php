<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Responsablesue
 *
 * @ORM\Table(name="responsablesue")
 * @ORM\Entity
 */
class Responsablesue
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
     * @ORM\Column(name="idUE", type="integer", nullable=false)
     */
    private $idue;

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
     * @return Responsablesue
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
     * Set idue
     *
     * @param integer $idue
     *
     * @return Responsablesue
     */
    public function setIdue($idue)
    {
        $this->idue = $idue;

        return $this;
    }

    /**
     * Get idue
     *
     * @return integer
     */
    public function getIdue()
    {
        return $this->idue;
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
