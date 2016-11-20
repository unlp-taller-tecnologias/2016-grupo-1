<?php namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Examen
 *
 * @ORM\Table(name="examen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExamenRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Examen {
    public function __construct(Usuario $medico = null, Paciente $paciente = null) {
        $this->factores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->medicaciones = new \Doctrine\Common\Collections\ArrayCollection();
        if ($medico !== null) {
            $this->setMedico($medico);
        }
        if ($paciente !== null) {
            $this->setPaciente($paciente);
        }
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="otros_factores", type="string", length=255, nullable=true)
     */
    private $otrosFactores;

    /**
     * @var string
     *
     * @ORM\Column(name="otras_medicaciones", type="string", length=255, nullable=true)
     */
    private $otrasMedicaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="derivado_desde", type="string", length=255, nullable=true)
     */
    private $derivadoDesde;

    /**
     * @var integer
     *
     * @ORM\Column(name="grado_riesgo", type="integer")
     */
    private $gradoRiesgo;

    /**
     * @var string
     *
     * @ORM\Column(name="antecedentes", type="text", nullable=true)
     */
    private $antecedentes;

    /**
     * @var string
     *
     * @ORM\Column(name="procedimiento", type="string", length=255)
     */
    private $procedimiento;

    /**
     * @ORM\ManyToMany(targetEntity="Factor")
     * @ORM\JoinTable(name="examen_factor", 
     *  joinColumns={@ORM\JoinColumn(name="factor_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="examen_id", referencedColumnName="id")}
     * )
     */
    private $factores;

    /**
     * @ORM\ManyToMany(targetEntity="Medicacion")
     * @ORM\JoinTable(name="examen_medicacion", 
     *  joinColumns={@ORM\JoinColumn(name="medicacion_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="examen_id", referencedColumnName="id")}
     * )
     */
    private $medicaciones;

    /**
     * @ORM\ManyToOne(targetEntity="Paciente")
     * @ORM\JoinColumn(name="paciente_id", referencedColumnName="id", nullable=false)
     */
    private $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="medico_id", referencedColumnName="id", nullable=false)
     */
    private $medico;

    /**
     * @var bool
     *
     * @ORM\Column(name="ruido_1", type="boolean", nullable=true)
     */
    private $ruido1;

    /**
     * @var bool
     *
     * @ORM\Column(name="ruido_2", type="boolean", nullable=true)
     */
    private $ruido2;

    /**
     * @var string
     *
     * @ORM\Column(name="ruido_3", type="boolean", nullable=true)
     */
    private $ruido3;

    /**
     * @var bool
     *
     * @ORM\Column(name="ruido_4", type="boolean", nullable=true)
     */
    private $ruido4;

    /**
     * @var int
     *
     * @ORM\Column(name="tension_arterial_sistolica", type="integer")
     */
    private $tensionArterialSistolica;

    /**
     * @var int
     *
     * @ORM\Column(name="tension_arterial_diastolica", type="integer")
     */
    private $tensionArterialDiastolica;

    /**
     * @var bool
     *
     * @ORM\Column(name="soplos", type="boolean")
     */
    private $soplos;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarios", type="text", nullable=true)
     */
    private $comentarios;

    /**
     * @var string
     *
     * @ORM\Column(name="aparato_respiratorio", type="text", nullable=true)
     */
    private $aparatoRespiratorio;

    /**
     * @var string
     *
     * @ORM\Column(name="electrocardiograma", type="text", nullable=true)
     */
    private $electrocardiograma;

    /**
     * @var string
     *
     * @ORM\Column(name="spolos_comentario", type="string", length=255, nullable=true)
     */
    private $spolosComentario;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Examen
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set otrosFactores
     *
     * @param string $otrosFactores
     * @return Examen
     */
    public function setOtrosFactores($otrosFactores) {
        $this->otrosFactores = $otrosFactores;

        return $this;
    }

    /**
     * Get otrosFactores
     *
     * @return string 
     */
    public function getOtrosFactores() {
        return $this->otrosFactores;
    }

    /**
     * Agregar medicacion
     *
     * @param Medicacion $medicacion
     * @return Examen
     */
    public function addMedicacion(Medicacion $medicacion) {
        $this->medicaciones[] = $medicacion;

        return $this;
    }

    /**
     * Eliminar medicacion
     *
     * @param Medicacion $medicacion
     */
    public function removeMedicacion(Medicacion $medicacion) {
        $this->factores->removeElement($medicacion);
    }

    /**
     * Get medicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedicaciones() {
        return $this->medicaciones;
    }

    /**
     * Agregar factor
     *
     * @param Factor $factor
     * @return Examen
     */
    public function addFactor(Factor $factor) {
        $this->factores[] = $factor;

        return $this;
    }

    /**
     * Eliminar factor
     *
     * @param Factor $factor
     */
    public function removeFactor(Factor $factor) {
        $this->factores->removeElement($factor);
    }

    /**
     * Get factores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFactores() {
        return $this->factores;
    }

    /**
     * Set paciente
     *
     * @param Paciente $paciente
     * @return Examen
     */
    public function setPaciente($paciente) {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return Paciente 
     */
    public function getPaciente() {
        return $this->paciente;
    }

    /**
     * Set medico
     *
     * @param Usuario $usuario
     * @return Examen
     */
    public function setMedico($usuario) {
        $this->medico = $usuario;

        return $this;
    }

    /**
     * Get medico
     *
     * @return Usuario 
     */
    public function getMedico() {
        return $this->medico;
    }

    /**
     * Set otrasMedicaciones
     *
     * @param string $otrasMedicaciones
     * @return Examen
     */
    public function setOtrasMedicaciones($otrasMedicaciones) {
        $this->otrasMedicaciones = $otrasMedicaciones;

        return $this;
    }

    /**
     * Get otrasMedicaciones
     *
     * @return string 
     */
    public function getOtrasMedicaciones() {
        return $this->otrasMedicaciones;
    }

    /**
     * Set derivadoDesde
     *
     * @param string $derivadoDesde
     * @return Examen
     */
    public function setDerivadoDesde($derivadoDesde) {
        $this->derivadoDesde = $derivadoDesde;

        return $this;
    }

    /**
     * Get derivadoDesde
     *
     * @return string 
     */
    public function getDerivadoDesde() {
        return $this->derivadoDesde;
    }

    /**
     * Set gradoRiesgo
     *
     * @param int $gradoRiesgo
     * @return Examen
     */
    public function setGradoRiesgo($gradoRiesgo) {
        $this->gradoRiesgo = $gradoRiesgo;

        return $this;
    }

    /**
     * Get gradoRiesgo
     *
     * @return int 
     */
    public function getGradoRiesgo() {
        return $this->gradoRiesgo;
    }

    /**
     * Set antecedentes
     *
     * @param string $antecedentes
     * @return Examen
     */
    public function setAntecedentes($antecedentes) {
        $this->antecedentes = $antecedentes;

        return $this;
    }

    /**
     * Get antecedentes
     *
     * @return string 
     */
    public function getAntecedentes() {
        return $this->antecedentes;
    }

    /**
     * Set procedimiento
     *
     * @param string $procedimiento
     * @return Examen
     */
    public function setProcedimiento($procedimiento) {
        $this->procedimiento = $procedimiento;

        return $this;
    }

    /**
     * Get procedimiento
     *
     * @return string 
     */
    public function getProcedimiento() {
        return $this->procedimiento;
    }

    /**
     * Set ruido1
     *
     * @param boolean $ruido1
     * @return Examen
     */
    public function setRuido1($ruido1) {
        $this->ruido1 = $ruido1;

        return $this;
    }

    /**
     * Get ruido1
     *
     * @return boolean 
     */
    public function getRuido1() {
        return $this->ruido1;
    }

    /**
     * Set ruido2
     *
     * @param boolean $ruido2
     * @return Examen
     */
    public function setRuido2($ruido2) {
        $this->ruido2 = $ruido2;

        return $this;
    }

    /**
     * Get ruido2
     *
     * @return boolean 
     */
    public function getRuido2() {
        return $this->ruido2;
    }

    /**
     * Set ruido3
     *
     * @param string $ruido3
     * @return Examen
     */
    public function setRuido3($ruido3) {
        $this->ruido3 = $ruido3;

        return $this;
    }

    /**
     * Get ruido3
     *
     * @return string 
     */
    public function getRuido3() {
        return $this->ruido3;
    }

    /**
     * Set ruidp4
     *
     * @param boolean $ruido4
     * @return Examen
     */
    public function setRuido4($ruido4) {
        $this->ruidp4 = $ruido4;

        return $this;
    }

    /**
     * Get ruidp4
     *
     * @return boolean 
     */
    public function getRuido4() {
        return $this->ruido4;
    }

    /**
     * Set tensionArterialSistolica
     *
     * @param integer $tensionArterialSistolica
     * @return Examen
     */
    public function setTensionArterialSistolica($tensionArterialSistolica) {
        $this->tensionArterialSistolica = $tensionArterialSistolica;

        return $this;
    }

    /**
     * Get tensionArterialSistolica
     *
     * @return integer 
     */
    public function getTensionArterialSistolica() {
        return $this->tensionArterialSistolica;
    }

    /**
     * Set tensionArterialDiastolica
     *
     * @param integer $tensionArterialDiastolica
     * @return Examen
     */
    public function setTensionArterialDiastolica($tensionArterialDiastolica) {
        $this->tensionArterialDiastolica = $tensionArterialDiastolica;

        return $this;
    }

    /**
     * Get tensionArterialDiastolica
     *
     * @return integer 
     */
    public function getTensionArterialDiastolica() {
        return $this->tensionArterialDiastolica;
    }

    /**
     * Set soplos
     *
     * @param boolean $soplos
     * @return Examen
     */
    public function setSoplos($soplos) {
        $this->soplos = $soplos;

        return $this;
    }

    /**
     * Get soplos
     *
     * @return boolean 
     */
    public function getSoplos() {
        return $this->soplos;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     * @return Examen
     */
    public function setComentarios($comentarios) {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios() {
        return $this->comentarios;
    }

    /**
     * Set aparatoRespiratorio
     *
     * @param string $aparatoRespiratorio
     * @return Examen
     */
    public function setAparatoRespiratorio($aparatoRespiratorio) {
        $this->aparatoRespiratorio = $aparatoRespiratorio;

        return $this;
    }

    /**
     * Get aparatoRespiratorio
     *
     * @return string 
     */
    public function getAparatoRespiratorio() {
        return $this->aparatoRespiratorio;
    }

    /**
     * Set electrocardiograma
     *
     * @param string $electrocardiograma
     * @return Examen
     */
    public function setElectrocardiograma($electrocardiograma) {
        $this->electrocardiograma = $electrocardiograma;

        return $this;
    }

    /**
     * Get electrocardiograma
     *
     * @return string 
     */
    public function getElectrocardiograma() {
        return $this->electrocardiograma;
    }

    /**
     * Set spolosComentario
     *
     * @param string $spolosComentario
     * @return Examen
     */
    public function setSpolosComentario($spolosComentario) {
        $this->spolosComentario = $spolosComentario;

        return $this;
    }

    /**
     * Get spolosComentario
     *
     * @return string 
     */
    public function getSpolosComentario() {
        return $this->spolosComentario;
    }

}
