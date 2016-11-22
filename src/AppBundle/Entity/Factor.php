<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Factor
 *
 * @ORM\Entity
 * @ORM\Table(name="factor_de_riesgo")
 * @UniqueEntity("factor", message="El factor de riesgo ya existe")
 */
class Factor
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="factor", type="string", unique=true)
     * @Assert\NotBlank(message="Por favor, ingrese un factor de riesgo")
     */
    protected $factor;


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
     * Set factor
     *
     * @param string $factor
     * @return Factor
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;

        return $this;
    }

    /**
     * Get factor
     *
     * @return string 
     */
    public function getFactor()
    {
        return $this->factor;
    }
    
    public function __toString()
    {
        return $this->getFactor();
    }
}
