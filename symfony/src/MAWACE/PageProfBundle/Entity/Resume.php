<?php

namespace MAWACE\PageProfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resume
 *
 * @ORM\Table(name="resume")
 * @ORM\Entity(repositoryClass="MAWACE\PageProfBundle\Repository\ResumeRepository")
 */
class Resume
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

