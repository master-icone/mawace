<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\coursRepository")
 */
class cours
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
     * @ORM\Column(name="idUE", type="integer")
     */
    private $idUE;

    /**
     * @var int
     *
     * @ORM\Column(name="idTypeCours", type="integer")
     */
    private $idTypeCours;

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
     * Set idUE
     *
     * @param integer $idUE
     *
     * @return cours
     */
    public function setIdUE($idUE)
    {
        $this->idUE = $idUE;

        return $this;
    }

    /**
     * Get idUE
     *
     * @return int
     */
    public function getIdUE()
    {
        return $this->idUE;
    }

    /**
     * Set idTypeCours
     *
     * @param integer $idTypeCours
     *
     * @return cours
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
     * Set annee
     *
     * @param string $annee
     *
     * @return cours
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

