<?php

namespace Previsionnel\ticketBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * ticket
 *
 * @ORM\Table(name="tickets")
 * @ORM\Entity(repositoryClass="Previsionnel\ticketBundle\Repository\ticketRepository")
 */
class ticket
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
     * @ORM\Column(name="motif", type="string", length=255)
     *
     * @Assert\NotBlank(message="champ obligatoire")
     *
     */
    private $motif;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     *
     * @Assert\NotBlank(message="champ obligatoire")
     *
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=1)
     *
     */
    private $etat = 'C';

    /**
     * @var int
     *
     * @ORM\Column(name="IdExpediteur", type="integer")
     *
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $IdExpediteur;

    /**
     * @var int
     *
     * @ORM\Column(name="idUE", type="integer")
     *
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private $idUE;


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
     * Set motif
     *
     * @param string $motif
     *
     * @return ticket
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
     * @return ticket
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ticket
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
     * @return ticket
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
     * Set IdExpediteur
     *
     * @param string $IdExpediteur
     *
     * @return ticket
     */
    public function setIdExpediteur($IdExpediteur)
    {
        $this->IdExpediteur = $IdExpediteur;

        return $this;
    }

    /**
     * Get IdExpediteur
     *
     * @return int
     */
    public function getIdExpediteur()
    {
        return $this->IdExpediteur;
    }

    /**
     * Set idUE
     *
     * @param integer $idUE
     *
     * @return ticket
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
}

