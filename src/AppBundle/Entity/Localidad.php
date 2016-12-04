<?php namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Localidad
 *
 * @ORM\Entity
 * @ORM\Table(name="localidad")
 * @UniqueEntity({"localidad", "partido"}, message="Ya existe una localidad con ese nombre en el partido seleccionado")
 */
class Localidad implements \JsonSerializable {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="localidad", type="string")
     * @Assert\NotBlank(message="Por favor, ingrese una localidad")
     */
    protected $localidad;

    /**
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="localidades")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Por favor, seleccione un partido")
     */
    protected $partido;

    /**
     * @ORM\OneToMany(targetEntity="Paciente", mappedBy="localidad")
     * @ORM\OrderBy({"apellido" = "ASC", "nombre" = "ASC"})
     */
    protected $pacientes;

    public function __construct() {
        $this->pacientes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Localidad
     */
    public function setLocalidad($localidad) {
        $this->localidad = ucwords(strtolower($localidad));

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad() {
        return $this->localidad;
    }

    /**
     * Set partido
     *
     * @param Partido $partido
     * @return Localidad
     */
    public function setPartido(Partido $partido = null) {
        $this->partido = $partido;

        return $this;
    }

    /**
     * Get partido
     *
     * @return Partido
     */
    public function getPartido() {
        return $this->partido;
    }

    /**
     * Add pacientes
     *
     * @param Paciente $paciente
     * @return Localidad
     */
    public function addPaciente(Paciente $paciente) {
        $this->pacientes[] = $paciente;

        return $this;
    }

    /**
     * Remove pacientes
     *
     * @param Paciente $paciente
     */
    public function removePaciente(Paciente $paciente) {
        $this->pacientes->removeElement($paciente);
    }

    /**
     * Get pacientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPacientes() {
        return $this->pacientes;
    }

    public function __toString() {
        return $this->localidad . ' - ' . $this->partido;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'localidad' => $this->localidad
        );
    }

}
