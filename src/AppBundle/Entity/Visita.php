<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VisitaMedica
 *
 * @ORM\Entity
 * @ORM\Table(name="visita")
 */
class Visita
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotBlank(message="Por favor, ingrese una fecha")
     */
    protected $fecha;

    /**
     * @ORM\Column(name="observaciones", type="string", length=900, nullable=true)
     * @Assert\Length(max=900)
     */
    protected $observaciones;

    /**
     * @ORM\Column(name="notas_personales", type="string", length=900, nullable=true)
     * @Assert\Length(max=900)
     */
    protected $notasPersonales;

    /**
     * @ORM\ManyToMany(targetEntity="Motivo")
     * @ORM\JoinTable(name="visita_motivo",
     *      joinColumns={@ORM\JoinColumn(name="visita_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="motivo_id", referencedColumnName="id")}
     *      )
     */
    protected $motivos;

    /**
     * @ORM\ManyToMany(targetEntity="Diagnostico")
     * @ORM\JoinTable(name="visita_diagnostico",
     *      joinColumns={@ORM\JoinColumn(name="visita_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="diagnostico_id", referencedColumnName="id")}
     *      )
     */
    protected $diagnosticos;

    /**
     * @ORM\ManyToOne(targetEntity="Paciente", inversedBy="visitas")
     * @ORM\JoinColumn(name="paciente_id", referencedColumnName="id", nullable=false)
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $medico;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->motivos = new ArrayCollection();
        $this->diagnosticos = new ArrayCollection();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Visita
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Visita
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set notasPersonales
     *
     * @param string $notasPersonales
     * @return Visita
     */
    public function setNotasPersonales($notasPersonales)
    {
        $this->notasPersonales = $notasPersonales;

        return $this;
    }

    /**
     * Get notasPersonales
     *
     * @return string 
     */
    public function getNotasPersonales()
    {
        return $this->notasPersonales;
    }

    /**
     * Add motivos
     *
     * @param Motivo $motivos
     * @return Visita
     */
    public function addMotivo(Motivo $motivos)
    {
        $this->motivos[] = $motivos;

        return $this;
    }

    /**
     * Remove motivos
     *
     * @param Motivo $motivos
     */
    public function removeMotivo(Motivo $motivos)
    {
        $this->motivos->removeElement($motivos);
    }

    /**
     * Get motivos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMotivos()
    {
        return $this->motivos;
    }

    /**
     * Add diagnosticos
     *
     * @param Diagnostico $diagnosticos
     * @return Visita
     */
    public function addDiagnostico(Diagnostico $diagnosticos)
    {
        $this->diagnosticos[] = $diagnosticos;

        return $this;
    }

    /**
     * Remove diagnosticos
     *
     * @param Diagnostico $diagnosticos
     */
    public function removeDiagnostico(Diagnostico $diagnosticos)
    {
        $this->diagnosticos->removeElement($diagnosticos);
    }

    /**
     * Get diagnosticos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDiagnosticos()
    {
        return $this->diagnosticos;
    }

    /**
     * Set paciente
     *
     * @param Paciente $paciente
     * @return Visita
     */
    public function setPaciente(Paciente $paciente)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set medico
     *
     * @param Usuario $medico
     * @return Visita
     */
    public function setMedico(Usuario $medico)
    {
        $this->medico = $medico;

        return $this;
    }

    /**
     * Get medico
     *
     * @return Usuario
     */
    public function getMedico()
    {
        return $this->medico;
    }
}
