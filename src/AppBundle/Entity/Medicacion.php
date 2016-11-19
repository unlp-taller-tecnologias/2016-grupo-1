<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medicacion
 *
 * @ORM\Table(name="medicacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedicacionRepository")
 */
class Medicacion
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
     * @ORM\Column(name="medicacion", type="string", length=255, unique=true)
     */
    private $medicacion;


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
    
    public function __toString() {
        return $this->getMedicacion();
    }
}
