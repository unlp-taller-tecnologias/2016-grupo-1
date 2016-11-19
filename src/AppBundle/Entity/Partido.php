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
        $this->partido = $partido;

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
     * @param Localidad $localidades
     * @return Partido
     */
    public function addLocalidade(Localidad $localidades)
    {
        $this->localidades[] = $localidades;

        return $this;
    }

    /**
     * Remove localidades
     *
     * @param Localidad $localidades
     */
    public function removeLocalidade(Localidad $localidades)
    {
        $this->localidades->removeElement($localidades);
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
    public function __toString() {
        return $this->partido;
    }
}
