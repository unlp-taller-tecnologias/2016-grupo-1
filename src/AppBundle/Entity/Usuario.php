<?php


namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as FOSUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends FOSUser
{
    const PROFESION_MEDICO     = 1;
    const PROFESION_SECRETARIO = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\NotBlank(message="Por favor, ingrese su nombre", groups={"Registration", "Profile"})
     * @Assert\Length(max=35, maxMessage="El nombre es muy largo", groups={"Registration", "Profile"})
     * )
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\NotBlank(message="Por favor, ingrese su apellido", groups={"Registration", "Profile"})
     * @Assert\Length(max=35, maxMessage="El apellido es muy largo", groups={"Registration", "Profile"})
     */
    protected $apellido;

    /** @ORM\Column(type="string", length=20, nullable=true) */
    protected $telefono;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Por favor, seleccione una opción", groups={"Registration", "Profile"})
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
     * @return Usuario
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
     * @param integer $profesion
     * @return Usuario
     */
    public function setProfesion($profesion)
    {
        if (!in_array($profesion, [
            self::PROFESION_MEDICO,
            self::PROFESION_SECRETARIO,
        ])) {
            throw new \InvalidArgumentException("Profesión inválida");
        }
        $this->profesion = $profesion;

        return $this;
    }
}