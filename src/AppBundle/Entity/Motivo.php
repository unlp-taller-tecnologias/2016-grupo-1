<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Motivo
 *
 * @ORM\Entity
 * @ORM\Table(name="motivo")
 * @UniqueEntity("motivo", message="El motivo de consulta ya existe")
 */
class Motivo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="motivo", type="string", unique=true)
     * @Assert\NotBlank(message="Por favor, ingrese un motivo de consulta")
     */
    protected $motivo;


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
     * Set motivo
     *
     * @param string $motivo
     * @return Motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Motivo to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->motivo;
    }
}
