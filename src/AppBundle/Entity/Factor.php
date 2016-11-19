<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factor
 *
 * @ORM\Table(name="factor_de_riesgo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactorRepository")
 */
class Factor
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
     * @ORM\Column(name="factor", type="string", length=255, unique=true)
     */
    private $factor;


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
    
    public function __toString() {
        return $this->getFactor();
    }
}
