<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * coefficientssupplementaires
 *
 * @ORM\Table(name="coefficientssupplementaires")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\coefficientssupplementairesRepository")
 */
class coefficientssupplementaires
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
     * @ORM\Column(name="idTypeCours", type="integer")
     */
    private $idTypeCours;

    /**
     * @var string
     *
     * @ORM\Column(name="coeff", type="decimal", precision=2, scale=0)
     */
    private $coeff;

    /**
     * @var int
     *
     * @ORM\Column(name="idStatut", type="integer")
     */
    private $idStatut;

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
     * Set idTypeCours
     *
     * @param integer $idTypeCours
     *
     * @return coefficientssupplementaires
     */
    public function setIdTypeCours($idTypeCours)
    {
        $this->idTypeCours = $idTypeCours;

        return $this;
    }

    /**
     * Get idTypeCours
     *
     * @return int
     */
    public function getIdTypeCours()
    {
        return $this->idTypeCours;
    }

    /**
     * Set coeff
     *
     * @param string $coeff
     *
     * @return coefficientssupplementaires
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;

        return $this;
    }

    /**
     * Get coeff
     *
     * @return string
     */
    public function getCoeff()
    {
        return $this->coeff;
    }

    /**
     * Set idStatut
     *
     * @param integer $idStatut
     *
     * @return coefficientssupplementaires
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
     * Set annee
     *
     * @param string $annee
     *
     * @return coefficientssupplementaires
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

