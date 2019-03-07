<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="evaluaciones")
 */
class Evaluacion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comentario_supervisor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comentario_supervisado;

    /**
     * @ORM\Column(type="integer")
     */
    protected $total_objetivos;

    /**
     * @ORM\Column(type="integer")
     */
    protected $total_competencias;

    /**
     * @ORM\Column(type="integer")
     */
    protected $total;

    /**
     * @ORM\Column(type="date")
     */
    protected $fecha;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fecha_evaluado;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $aprobacion_evaluado;

    /**
     * @ORM\ManyToOne(targetEntity="Odi", inversedBy="evalcompetencia", cascade={"persist"})
     * @ORM\JoinColumn(name="odi_id", referencedColumnName="id")
     **/
    protected $odi;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $logro_adicional;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $impacto; 

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $competencias_individual;    

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
     * Set comentario_supervisor
     *
     * @param string $comentarioSupervisor
     * @return Evaluacion
     */
    public function setComentarioSupervisor($comentarioSupervisor)
    {
        $this->comentario_supervisor = $comentarioSupervisor;

        return $this;
    }

    /**
     * Get comentario_supervisor
     *
     * @return string 
     */
    public function getComentarioSupervisor()
    {
        return $this->comentario_supervisor;
    }

    /**
     * Set comentario_supervisado
     *
     * @param string $comentarioSupervisado
     * @return Evaluacion
     */
    public function setComentarioSupervisado($comentarioSupervisado)
    {
        $this->comentario_supervisado = $comentarioSupervisado;

        return $this;
    }

    /**
     * Get comentario_supervisado
     *
     * @return string 
     */
    public function getComentarioSupervisado()
    {
        return $this->comentario_supervisado;
    }

    /**
     * Set total_objetivos
     *
     * @param integer $totalObjetivos
     * @return Evaluacion
     */
    public function setTotalObjetivos($totalObjetivos)
    {
        $this->total_objetivos = $totalObjetivos;

        return $this;
    }

    /**
     * Get total_objetivos
     *
     * @return integer 
     */
    public function getTotalObjetivos()
    {
        return $this->total_objetivos;
    }

    /**
     * Set total_competencias
     *
     * @param integer $totalCompetencias
     * @return Evaluacion
     */
    public function setTotalCompetencias($totalCompetencias)
    {
        $this->total_competencias = $totalCompetencias;

        return $this;
    }

    /**
     * Get total_competencias
     *
     * @return integer 
     */
    public function getTotalCompetencias()
    {
        return $this->total_competencias;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Evaluacion
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Evaluacion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fecha_evaluado
     *
     * @param \DateTime $fechaEvaluado
     * @return Evaluacion
     */
    public function setFechaEvaluado($fechaEvaluado)
    {
        $this->fecha_evaluado = $fechaEvaluado;

        return $this;
    }

    /**
     * Get fecha_evaluado
     *
     * @return \DateTime 
     */
    public function getFechaEvaluado()
    {
        return $this->fecha_evaluado;
    }

    /**
     * Set aprobacion_evaluado
     *
     * @param boolean $aprobacionEvaluado
     * @return Evaluacion
     */
    public function setAprobacionEvaluado($aprobacionEvaluado)
    {
        $this->aprobacion_evaluado = $aprobacionEvaluado;

        return $this;
    }

    /**
     * Get aprobacion_evaluado
     *
     * @return boolean 
     */
    public function getAprobacionEvaluado()
    {
        return $this->aprobacion_evaluado;
    }

    /**
     * Set odi
     *
     * @param \cufm\SedaBundle\Entity\Odi $odi
     * @return Evaluacion
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
     * Set logro_adicional
     *
     * @param string $logroAdicional
     * @return Evaluacion
     */
    public function setLogroAdicional($logroAdicional)
    {
        $this->logro_adicional = $logroAdicional;

        return $this;
    }

    /**
     * Get logro_adicional
     *
     * @return string 
     */
    public function getLogroAdicional()
    {
        return $this->logro_adicional;
    }

    /**
     * Set impacto
     *
     * @param string $impacto
     * @return Evaluacion
     */
    public function setImpacto($impacto)
    {
        $this->impacto = $impacto;

        return $this;
    }

    /**
     * Get impacto
     *
     * @return string 
     */
    public function getImpacto()
    {
        return $this->impacto;
    }

    /**
     * Set competencias_individual
     *
     * @param string $competenciasIndividual
     * @return Evaluacion
     */
    public function setCompetenciasIndividual($competenciasIndividual)
    {
        $this->competencias_individual = $competenciasIndividual;

        return $this;
    }

    /**
     * Get competencias_individual
     *
     * @return string 
     */
    public function getCompetenciasIndividual()
    {
        return $this->competencias_individual;
    }
}
