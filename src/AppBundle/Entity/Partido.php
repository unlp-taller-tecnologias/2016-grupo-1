<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Partido
 *
 * @ORM\Entity
 * @ORM\Table(name="partido")
 * @UniqueEntity("partido", message="El partido ya existe")
 */
class Partido
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="partido", type="string", unique=true)
     * @Assert\NotBlank(message="Por favor, ingrese un partido")
     */
    protected $partido;

    /**
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="partido")
     * @ORM\OrderBy({"localidad" = "ASC"})
     */
    protected $localidades;


    public function __construct()
    {
        $this->localidades = new ArrayCollection();
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
     * Set partido
     *
     * @param string $partido
     * @return Partido
     */
    public function setPartido($partido)
    {
        $this->partido = ucwords(strtolower($partido));

        return $this;
    }

    /**
     * Get partido
     *
     * @return string 
     */
    public function getPartido()
    {
        return $this->partido;
    }

    /**
     * Add localidades
     *
     * @param Localidad $localidad
     * @return Partido
     */
    public function addLocalidad(Localidad $localidad)
    {
        $this->localidades[] = $localidad;

        return $this;
    }

    /**
     * Remove localidades
     *
     * @param Localidad $localidad
     */
    public function removeLocalidade(Localidad $localidad)
    {
        $this->localidades->removeElement($localidad);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }

    /**
     * Partido to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->partido;
    }
}
