<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="odis")
 */
class Odi
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $periodo;

    /**
     * @ORM\Column(type="string", length=4)
     */
    protected $ano;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
     protected $vbogth;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fecha_vbogth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
     protected $vbevaluado;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $fecha_vbevaluado;

    /**
     * @ORM\OneToMany(targetEntity="Objetivo", mappedBy="odi", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    protected $objetivos;

    /**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="odis")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
	*/
	protected $usuario;

    /**
     * @ORM\OneToMany(targetEntity="EvaluacionCompetencia", mappedBy="odi", cascade={"persist", "remove"})
     **/
    private $evalcompetencia;

    /**
     * @ORM\OneToMany(targetEntity="Evaluacion", mappedBy="odi", cascade={"persist", "remove"})
     **/
    private $evaluacion;

    /**
     * @ORM\ManyToOne(targetEntity="Dependencia", inversedBy="odis")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id")
     *
     */
    protected $dependencia;

    /**
	  * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="odis")
	  * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
	  *
	  */
	  protected $cargo;

    /**
	  * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="creador")
	  * @ORM\JoinColumn(name="creador_id", referencedColumnName="id")
	  */
	  protected $creadopor;


    public function __toString() //Metodo Majico
     {
        $periodo = $this->getPeriodo();
        $ano = $this->getAno();
        $funcionario = $this->getUsuario();
        $odi = $funcionario.'del '.$periodo.'del '.$ano;
       return $odi;
     }


    /**
     * Constructor
     */

    public function __construct()
    {
        $this->objetivos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set id
     *
     * @return integer
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * Set periodo
     *
     * @param integer $periodo
     * @return Odi
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set ano
     *
     * @param string $ano
     * @return Odi
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * Get ano
     *
     * @return string
     */
    public function getAno()
    {
        return $this->ano;
    }

    public function setObjetivos(\Doctrine\Common\Collections\Collection $objetivos)
    {
        $this->objetivos = $objetivos;
        foreach ($objetivos as $objetivo) {
            $objetivo->setOdi($this);
        }
    }


    /**
     * Get objetivos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjetivos()
    {
        return $this->objetivos;
    }

    /**
     * Set usuario
     *
     * @param \cufm\SedaBundle\Entity\Usuario $usuario
     * @return Odi
     */
    public function setUsuario(\cufm\SedaBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \cufm\SedaBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set vbogth
     *
     * @param boolean $vbogth
     * @return Odi
     */
    public function setVbogth($vbogth)
    {
        $this->vbogth = $vbogth;

        return $this;
    }

    /**
     * Get vbogth
     *
     * @return boolean
     */
    public function getVbogth()
    {
        return $this->vbogth;
    }

    /**
     * Set fecha_vbogth
     *
     * @param \DateTime $fechaVbogth
     * @return Odi
     */
    public function setFechaVbogth($fechaVbogth)
    {
        $this->fecha_vbogth = $fechaVbogth;

        return $this;
    }

    /**
     * Get fecha_vbogth
     *
     * @return \DateTime
     */
    public function getFechaVbogth()
    {
        return $this->fecha_vbogth;
    }

    /**
     * Set vbevaluado
     *
     * @param boolean $vbevaluado
     * @return Odi
     */
    public function setVbevaluado($vbevaluado)
    {
        $this->vbevaluado = $vbevaluado;

        return $this;
    }

    /**
     * Get vbevaluado
     *
     * @return boolean
     */
    public function getVbevaluado()
    {
        return $this->vbevaluado;
    }

    /**
     * Set fecha_vbevaluado
     *
     * @param \DateTime $fechaVbevaluado
     * @return Odi
     */
    public function setFechaVbevaluado($fechaVbevaluado)
    {
        $this->fecha_vbevaluado = $fechaVbevaluado;

        return $this;
    }

    /**
     * Get fecha_vbevaluado
     *
     * @return \DateTime
     */
    public function getFechaVbevaluado()
    {
        return $this->fecha_vbevaluado;
    }

    //OJO  borrar las funciones addObjetivos y removeObjetivos

    /**
     * Add evalcompetencia
     *
     * @param \cufm\SedaBundle\Entity\EvaluacionCompetencia $evalcompetencia
     * @return Odi
     */
    public function addEvalcompetencium(\cufm\SedaBundle\Entity\EvaluacionCompetencia $evalcompetencia)
    {
        $this->evalcompetencia[] = $evalcompetencia;

        return $this;
    }

    /**
     * Remove evalcompetencia
     *
     * @param \cufm\SedaBundle\Entity\EvaluacionCompetencia $evalcompetencia
     */
    public function removeEvalcompetencium(\cufm\SedaBundle\Entity\EvaluacionCompetencia $evalcompetencia)
    {
        $this->evalcompetencia->removeElement($evalcompetencia);
    }

    /**
     * Get evalcompetencia
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvalcompetencia()
    {
        return $this->evalcompetencia;
    }


    /**
     * Add evaluacion
     *
     * @param \cufm\SedaBundle\Entity\Evaluacion $evaluacion
     * @return Odi
     */
    public function addEvaluacion(\cufm\SedaBundle\Entity\Evaluacion $evaluacion)
    {
        $this->evaluacion[] = $evaluacion;

        return $this;
    }

    /**
     * Remove evaluacion
     *
     * @param \cufm\SedaBundle\Entity\Evaluacion $evaluacion
     */
    public function removeEvaluacion(\cufm\SedaBundle\Entity\Evaluacion $evaluacion)
    {
        $this->evaluacion->removeElement($evaluacion);
    }

    /**
     * Get evaluacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    /**
     * Set dependencia
     *
     * @param \cufm\SedaBundle\Entity\Dependencia $dependencia
     * @return Odi
     */
    public function setDependencia(\cufm\SedaBundle\Entity\Dependencia $dependencia = null)
    {
        $this->dependencia = $dependencia;

        return $this;
    }

    /**
     * Get dependencia
     *
     * @return \cufm\SedaBundle\Entity\Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * Set cargo
     *
     * @param \cufm\SedaBundle\Entity\Cargo $cargo
     * @return Odi
     */
    public function setCargo(\cufm\SedaBundle\Entity\Cargo $cargo = null)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return \cufm\SedaBundle\Entity\Cargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set creadopor
     *
     * @param \cufm\SedaBundle\Entity\Usuario $creadopor
     * @return Odi
     */
    public function setCreadopor(\cufm\SedaBundle\Entity\Usuario $creadopor = null)
    {
        $this->creadopor = $creadopor;

        return $this;
    }

    /**
     * Get creadopor
     *
     * @return \cufm\SedaBundle\Entity\Usuario
     */
    public function getCreadopor()
    {
        return $this->creadopor;
    }
}
