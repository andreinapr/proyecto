<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="objetivos")
 */
class Objetivo
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $objetivo;

    /**
     * @ORM\Column(type="integer")
     */
    protected $peso;

    /**
     * @ORM\Column(type="date")
     */
    protected $primera_revision;

    /**
     * @ORM\Column(type="date")
     */
    protected $segunda_revision;

    /**
     * @ORM\Column(type="date")
     */
    protected $tercera_revision;

    /**
     * @ORM\Column(type="date")
     */
    protected $fecha_creacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fecha_modificacion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fecha_evaluacion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rango;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $pesoxrango;


    /**
     * @ORM\ManyToOne(targetEntity="Odi", inversedBy="objetivos", cascade={"persist"})
     * @ORM\JoinColumn(name="odi_id", referencedColumnName="id")
     */
    protected $odi;

    /** 
     * @ORM\ManyToMany(targetEntity="Observacion", inversedBy="objetivo", cascade={"remove", "persist"})
     */
    protected $observaciones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set objetivo
     *
     * @param string $objetivo
     * @return Objetivo
     */
    public function setObjetivo($objetivo)
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    /**
     * Get objetivo
     *
     * @return string 
     */
    public function getObjetivo()
    {
        return $this->objetivo;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     * @return Objetivo
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return integer 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set primera_revision
     *
     * @param \DateTime $primeraRevision
     * @return Objetivo
     */
    public function setPrimeraRevision($primeraRevision)
    {
        $this->primera_revision = $primeraRevision;

        return $this;
    }

    /**
     * Get primera_revision
     *
     * @return \DateTime 
     */
    public function getPrimeraRevision()
    {
        return $this->primera_revision;
    }

    /**
     * Set segunda_revision
     *
     * @param \DateTime $segundaRevision
     * @return Objetivo
     */
    public function setSegundaRevision($segundaRevision)
    {
        $this->segunda_revision = $segundaRevision;

        return $this;
    }

    /**
     * Get segunda_revision
     *
     * @return \DateTime 
     */
    public function getSegundaRevision()
    {
        return $this->segunda_revision;
    }

    /**
     * Set tercera_revision
     *
     * @param \DateTime $terceraRevision
     * @return Objetivo
     */
    public function setTerceraRevision($terceraRevision)
    {
        $this->tercera_revision = $terceraRevision;

        return $this;
    }

    /**
     * Get tercera_revision
     *
     * @return \DateTime 
     */
    public function getTerceraRevision()
    {
        return $this->tercera_revision;
    }

    /**
     * Set fecha_creacion
     *
     * @param \DateTime $fechaCreacion
     * @return Objetivo
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fecha_creacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set fecha_modificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Objetivo
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fecha_modificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fecha_modificacion
     *
     * @return \DateTime 
     */
    public function getFechaModificacion()
    {
        return $this->fecha_modificacion;
    }

    /**
     * Set fecha_evaluacion
     *
     * @param \DateTime $fechaEvaluacion
     * @return Objetivo
     */
    public function setFechaEvaluacion($fechaEvaluacion)
    {
        $this->fecha_evaluacion = $fechaEvaluacion;

        return $this;
    }

    /**
     * Get fecha_evaluacion
     *
     * @return \DateTime 
     */
    public function getFechaEvaluacion()
    {
        return $this->fecha_evaluacion;
    }

    /**
     * Set rango
     *
     * @param integer $rango
     * @return Objetivo
     */
    public function setRango($rango)
    {
        $this->rango = $rango;

        return $this;
    }

    /**
     * Get rango
     *
     * @return integer 
     */
    public function getRango()
    {
        return $this->rango;
    }

    /**
     * Set pesoxrango
     *
     * @param integer $pesoxrango
     * @return Objetivo
     */
    public function setPesoxrango($pesoxrango)
    {
        $this->pesoxrango = $pesoxrango;

        return $this;
    }

    /**
     * Get pesoxrango
     *
     * @return integer 
     */
    public function getPesoxrango()
    {
        return $this->pesoxrango;
    }

    /**
     * Set odi
     *
     * @param \cufm\SedaBundle\Entity\Odi $odi
     * @return Objetivo
     */
    public function setOdi(\cufm\SedaBundle\Entity\Odi $odi = null)
    {
        $this->odi = $odi;

        return $this;
    }

    /**
     * Get odi
     *
     * @return \cufm\SedaBundle\Entity\Odi 
     */
    public function getOdi()
    {
        return $this->odi;
    }

    /**
     * Add observaciones
     *
     * @param \cufm\SedaBundle\Entity\Observacion $observaciones
     * @return Objetivo
     */
    public function addObservacione(\cufm\SedaBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones[] = $observaciones;

        return $this;
    }

    /**
     * Remove observaciones
     *
     * @param \cufm\SedaBundle\Entity\Observacion $observaciones
     */
    public function removeObservacione(\cufm\SedaBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones->removeElement($observaciones);
    }

    /**
     * Get observaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
