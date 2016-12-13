<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Paciente
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PacienteRepository")
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

    /**
     * @ORM\Column(name="dni", type="string", length=8, nullable=true, unique=true)
     * @Assert\Type(type="integer", message="El DNI sólo puede contener dígitos")
     * @Assert\Length(min=7, max=8, minMessage="El DNI debe tener al menos {{ limit }} dígitos", maxMessage="El DNI debe tener como máximo {{ limit }} dígitos")
     */
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
     * @ORM\Column(name="fecha_de_nacimiento", type="date")
     * @Assert\NotBlank(message="Por favor, ingrese la edad del paciente")
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

    /** @ORM\ManyToOne(targetEntity="Usuario") */
    protected $medico;

    /** @ORM\Column(name="obra_social", type="string", nullable=true) */
    protected $obraSocial;

    /**
     * @ORM\OneToMany(targetEntity="Visita", mappedBy="paciente")
     * @ORM\OrderBy({"fecha" = "ASC"})
     */
    protected $visitas;

    /**
     *  @ORM\OneToMany(targetEntity="Examen", mappedBy="paciente")
     *  @ORM\OrderBy({"fecha" = "ASC"})
     */
    protected $examenes;

    /** @Assert\Callback */
    public function validarEdad(ExecutionContextInterface $context)
    {
        if ($this->getEdad() > 122) {
            $violationBuilder = $context->buildViolation('La edad no puede superar los 122 años');
            $violationBuilder->atPath('edad')->addViolation();
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visitas = new ArrayCollection();
        $this->examenes = new ArrayCollection();
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
        $this->nombre = ucwords(strtolower($nombre));

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
        $this->apellido = ucwords(strtolower($apellido));

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
        $date = new \DateTime();
        $date->modify('-' . $edad . ' year');

        $this->edad = $date;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        if (!isset($this->edad)) {
            return $this->edad;
        }

        $diff = $this->edad->diff(new \DateTime());

        return $diff->y;
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
     * Set medico
     *
     * @param \AppBundle\Entity\Usuario $medico
     * @return Paciente
     */
    public function setMedico(Usuario $medico)
    {
        $this->medico = $medico;

        return $this;
    }

    /**
     * Get medico
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getMedico()
    {
        return $this->medico;
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
     * Add visita
     *
     * @param Visita $visita
     * @return Paciente
     */
    public function addVisita(Visita $visita)
    {
        $this->visitas[] = $visita;

        return $this;
    }

    /**
     * Remove visita
     *
     * @param Visita $visita
     * @return Paciente
     */
    public function removeVisita(Visita $visita)
    {
        $this->visitas->removeElement($visita);

        return $this;
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

    /**
     * Add examenes
     *
     * @param Examen $examen
     * @return Paciente
     */
    public function addExamen(Examen $examen)
    {
        $this->examenes[] = $examen;

        return $this;
    }

    /**
     * Remove examenes
     *
     * @param Examen $examen
     */
    public function removeExamen(Examen $examen)
    {
        $this->visitas->removeElement($examen);
    }

    /**
     * Get examenes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExamenes()
    {
        return $this->examenes;
    }

    /**
    * Paciente toString
    * @return string
    */
    public function __toString()
    {
        return $this->apellido . ' ' . $this->nombre;
    }
}
