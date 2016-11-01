<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Partido
 *
 * @ORM\Table(name="partido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartidoRepository")
 */
class Partido
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="partido", type="string", length=255, unique=true)
     */
    protected $partido;

    /**
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="Partido")
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
     * @param \AppBundle\Entity\Localidad $localidades
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
     * @param \AppBundle\Entity\Localidad $localidades
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
