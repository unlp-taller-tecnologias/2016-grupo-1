<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Medicacion
 *
 * @ORM\Entity
 * @ORM\Table(name="medicacion")
 * @UniqueEntity("medicacion", message="La medicación ya existe")
 */
class Medicacion
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="medicacion", type="string", unique=true)
     * @Assert\NotBlank(message="Por favor, ingrese una medicación")
     */
    protected $medicacion;


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
     * Set medicacion
     *
     * @param string $medicacion
     * @return Medicacion
     */
    public function setMedicacion($medicacion)
    {
        $this->medicacion = $medicacion;

        return $this;
    }

    /**
     * Get medicacion
     *
     * @return string 
     */
    public function getMedicacion()
    {
        return $this->medicacion;
    }
    
    public function __toString()
    {
        return $this->getMedicacion();
    }
}
