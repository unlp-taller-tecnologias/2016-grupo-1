<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Paciente
 *
 * @ORM\Entity
 * @ORM\Table(name="paciente")
 * @UniqueEntity("dni", message="El DNI ya existe")
 */
class Paciente
{
    const SEXO_MASCULINO = 'masculino';
    const SEXO_FEMENINO = 'femenino';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="dni", type="integer", nullable=true, unique=true) */
    protected $dni;

    /**
     * @ORM\Column(name="nombre", type="string")
     * @Assert\NotBlank(message="Por favor, ingrese un nombre")
     */
    protected $nombre;

    /**
     * @ORM\Column(name="apellido", type="string")
     * @Assert\NotBlank(message="Por favor, ingrese un apellido")
     */
    protected $apellido;

    /**
     * @ORM\Column(name="edad", type="integer")
     * @Assert\NotBlank(message="Por favor, ingrese la edad del paciente")
     * @Assert\Range(max=122, maxMessage="La edad no puede superar los 122 años")
     */
    protected $edad;

    /**
     * @ORM\Column(name="sexo", type="string")
     * @Assert\NotBlank(message="Por favor, seleccione un sexo")
     */
    protected $sexo;

    /**
     * @ORM\ManyToOne(targetEntity="Localidad", inversedBy="pacientes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Por favor, seleccione una localidad")
     */
    protected $localidad;

    /** @ORM\Column(name="obra_social", type="string", nullable=true) */
    protected $obraSocial;

    /** @ORM\OneToMany(targetEntity="Visita", mappedBy="paciente") */
    protected $visitas;


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
     * Set dni
     *
     * @param string $dni
     * @return Paciente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Paciente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Paciente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Paciente
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Paciente
     */
    public function setSexo($sexo)
    {
        if (!in_array($sexo, [
            self::SEXO_FEMENINO,
            self::SEXO_MASCULINO,
        ])) {
            throw new \InvalidArgumentException("Sexo inválido");
        }
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set localidad
     *
     * @param \AppBundle\Entity\Localidad $localidad
     * @return Paciente
     */
    public function setLocalidad(Localidad $localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \AppBundle\Entity\Localidad
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
    /**
     * Set obraSocial
     *
     * @param string $obraSocial
     * @return Paciente
     */
    public function setObraSocial($obraSocial)
    {
        $this->obraSocial = $obraSocial;

        return $this;
    }

    /**
     * Get obraSocial
     *
     * @return string
     */
    public function getObraSocial()
    {
        return $this->obraSocial;
    }
    
    /**
     * Paciente toString
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre() . " " . $this->getApellido();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visitas = new ArrayCollection();
    }

    /**
     * Add visitas
     *
     * @param Visita $visitas
     * @return Paciente
     */
    public function addVisita(Visita $visitas)
    {
        $this->visitas[] = $visitas;

        return $this;
    }

    /**
     * Remove visitas
     *
     * @param Visita $visitas
     */
    public function removeVisita(Visita $visitas)
    {
        $this->visitas->removeElement($visitas);
    }

    /**
     * Get visitas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVisitas()
    {
        return $this->visitas;
    }
}
