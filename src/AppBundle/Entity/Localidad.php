<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Localidad
 *
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocalidadRepository")
 */
class Localidad
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_postal", type="string", length=60, unique=true)
     */
    private $codPostal;

    /**
     * @ORM\ManyToOne(targetEntity="Partido", inversedBy="localidades")
     * @ORM\JoinColumn(name="partido_id", referencedColumnName="id")
     */
    protected $partido;


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
     * @param \AppBundle\Entity\Partido $partido
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
     * @return \AppBundle\Entity\Partido 
     */
    public function getPartido()
    {
        return $this->partido;
    }
}