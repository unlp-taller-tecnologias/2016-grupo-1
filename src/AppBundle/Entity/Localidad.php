<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Entity
 * @ORM\Table(name="localidad")
 */
class Localidad
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="localidad", type="string") */
    protected $localidad;

    /** @ORM\Column(name="cod_postal", type="string", length=60, unique=true) */
    protected $codPostal;

    /**
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="localidades")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $partido;

    /**
     * @ORM\OneToMany(targetEntity="Paciente", mappedBy="localidad")
     */
    protected $pacientes;


    public function __construct()
    {
        $this->pacientes = new ArrayCollection();
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
     * Set localidad
     *
     * @param string $localidad
     * @return Localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set codPostal
     *
     * @param string $codPostal
     * @return Localidad
     */
    public function setCodPostal($codPostal)
    {
        $this->codPostal = $codPostal;

        return $this;
    }

    /**
     * Get codPostal
     *
     * @return string
     */
    public function getCodPostal()
    {
        return $this->codPostal;
    }

    /**
     * Set partido
     *
     * @param Partido $partido
     * @return Localidad
     */
    public function setPartido(Partido $partido = null)
    {
        $this->partido = $partido;

        return $this;
    }

    /**
     * Get partido
     *
     * @return Partido
     */
    public function getPartido()
    {
        return $this->partido;
    }

    /**
     * Add pacientes
     *
     * @param Paciente $pacientes
     * @return Localidad
     */
    public function addPaciente(Paciente $pacientes)
    {
        $this->pacientes[] = $pacientes;

        return $this;
    }

    /**
     * Remove pacientes
     *
     * @param Paciente $pacientes
     */
    public function removePaciente(Paciente $pacientes)
    {
        $this->pacientes->removeElement($pacientes);
    }

    /**
     * Get pacientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacientes()
    {
        return $this->pacientes;
    }

    public function __toString()
    {
        return $this->localidad;
    }
}
