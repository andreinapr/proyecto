<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="objetivos_observaciones")
 */
class Observacion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $denominacion;

    /** 
     * @ORM\ManyToMany(targetEntity="Objetivo", mappedBy="observaciones")
     * 
     */
    protected $objetivo;

    public function __toString() //Metodo Majico
     {

       return $this->getDenominacion();
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Observacion
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string 
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set objetivo
     *
     * @param \cufm\SedaBundle\Entity\Objetivo $objetivo
     * @return Observacion
     */
    public function setObjetivo(\cufm\SedaBundle\Entity\Objetivo $objetivo = null)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return \cufm\SedaBundle\Entity\Objetivo 
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objetivo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add objetivo
     *
     * @param \cufm\SedaBundle\Entity\Objetivo $objetivo
     * @return Observacion
     */
    public function addObjetivo(\cufm\SedaBundle\Entity\Objetivo $objetivo)
    {
        $this->objetivo[] = $objetivo;

        return $this;
    }

    /**
     * Remove objetivo
     *
     * @param \cufm\SedaBundle\Entity\Objetivo $objetivo
     */
    public function removeObjetivo(\cufm\SedaBundle\Entity\Objetivo $objetivo)
    {
        $this->objetivo->removeElement($objetivo);
    }
}
