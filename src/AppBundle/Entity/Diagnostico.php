<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diagnostico
 *
 * @ORM\Table(name="diagnostico")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiagnosticoRepository")
 */
class Diagnostico
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
     * @ORM\Column(name="diagnostico", type="string", length=255, unique=true)
     */
    private $diagnostico;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return Diagnostico
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string 
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }
}
