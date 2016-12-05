<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as FOSUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * @ORM\Table(name="usuario")
 * @UniqueEntity("matricula", message="La matrícula ya está en uso")
 */
class Usuario extends FOSUser
{
    const PROFESION_MEDICO     = "médico";
    const PROFESION_SECRETARIO = "secretario";

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Type(type="integer", message="El DNI sólo puede contener dígitos", groups={"Registration"})
     * @Assert\Length(min=7, max=8, minMessage="El DNI debe tener al menos {{ limit }} dígitos", maxMessage="El DNI debe tener como máximo {{ limit }} dígitos")
     */
    protected $username;

    /**
     * @Assert\Regex(
     *  pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}/",
     *  message="La contraseña debe tener una longitud de 8 o más caracteres y estar conformada por al menos una letra minúscula, una mayúscula y un número."
     * )
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\NotBlank(message="Por favor, ingrese su nombre")
     * @Assert\Length(max=35, maxMessage="El nombre es muy largo")
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\NotBlank(message="Por favor, ingrese su apellido")
     * @Assert\Length(max=35, maxMessage="El apellido es muy largo")
     */
    protected $apellido;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20)
     */
    protected $telefono;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Por favor, seleccione una opción")
     */
    protected $profesion;

    /** @ORM\Column(type="string", nullable=true, unique=true) */
    protected $matricula;

    /** @ORM\Column(type="string", nullable=true) */
    protected $especialidad;


    /**
     * Set dni
     *
     * @param string $dni
     * @return Usuario
     */
    public function setDni($dni)
    {
        $this->username = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->username;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * @return Usuario
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
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     * @return Usuario
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set especialidad
     *
     * @param string $especialidad
     * @return Usuario
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * Get especialidad
     *
     * @return string
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * Get profesion
     *
     * @return integer
     */
    public function getProfesion()
    {
        return $this->profesion;
    }

    /**
     * Set profesion
     *
     * @param string $profesion
     * @return Usuario
     */
    public function setProfesion($profesion)
    {
        if (!in_array($profesion, [
            self::PROFESION_MEDICO,
            self::PROFESION_SECRETARIO,
        ])) {
            throw new \InvalidArgumentException("Ocupación inválida");
        }
        $this->profesion = $profesion;

        return $this;
    }

    public function __toString()
    {
        return $this->apellido . ' ' . $this->nombre;
    }
}
