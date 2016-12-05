<?php

namespace Previsionnel\PrevisionnelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tickets
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity
 */
class Tickets
{
    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=255, nullable=false)
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", length=65535, nullable=false)
     */
    private $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUE", type="integer", nullable=false)
     */
    private $idue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=1, nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="idExpediteur", type="integer", nullable=false)
     */
    private $idexpediteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return Tickets
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Tickets
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set idue
     *
     * @param integer $idue
     *
     * @return Tickets
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tickets
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Tickets
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set idexpediteur
     *
     * @param integer $idexpediteur
     *
     * @return Tickets
     */
    public function setIdexpediteur($idexpediteur)
    {
        $this->idexpediteur = $idexpediteur;

        return $this;
    }

    /**
     * Get idexpediteur
     *
     * @return integer
     */
    public function getIdexpediteur()
    {
        return $this->idexpediteur;
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
