<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Diagnostico
 *
 * @ORM\Entity
 * @ORM\Table(name="diagnostico")
 * @UniqueEntity("diagnostico", message="El diagnóstico ya existe")
 */
class Diagnostico
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="diagnostico", type="string", unique=true)
     * @Assert\NotBlank(message="Por favor, ingrese un diagnóstico")
     */
    protected $diagnostico;


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

    /**
     * Diagnóstico to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->diagnostico;
    }
}
