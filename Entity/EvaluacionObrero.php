<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluacionObrero
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cufm\SedaBundle\Entity\EvaluacionObreroRepository")
 */
class EvaluacionObrero
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="periodo", type="integer")
     */
    private $periodo;

    /**
     * @var string
     *
     * @ORM\Column(name="ano", type="string", length=4)
     */
    private $ano;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion1", type="integer")
     */
    private $factoresEvaluacion1;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion2", type="integer")
     */
    private $factoresEvaluacion2;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion3", type="integer")
     */
    private $factoresEvaluacion3;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion4", type="integer")
     */
    private $factoresEvaluacion4;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion5", type="integer")
     */
    private $factoresEvaluacion5;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion6", type="integer")
     */
    private $factoresEvaluacion6;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion7", type="integer")
     */
    private $factoresEvaluacion7;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresEvaluacion8", type="integer")
     */
    private $factoresEvaluacion8;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresSupervision1", type="integer", nullable=true)
     */
    private $factoresSupervision1;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresSupervision2", type="integer", nullable=true)
     */
    private $factoresSupervision2;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresSupervision3", type="integer", nullable=true)
     */
    private $factoresSupervision3;

    /**
     * @var integer
     *
     * @ORM\Column(name="factoresSupervision4", type="integer", nullable=true)
     */
    private $factoresSupervision4;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarioDesempeno", type="text", nullable=true)
     */
    private $comentarioDesempeno;

    /**
     * @var string
     *
     * @ORM\Column(name="aspectosMejorar", type="text", nullable=true)
     */
    private $aspectosMejorar;

    /**
     * @var string
     *
     * @ORM\Column(name="aspectosSignificativos", type="text", nullable=true)
     */
    private $aspectosSignificativos;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion_ogth", type="text", nullable=true)
     */
    private $observacionOGTH;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEvaluacion", type="date")
     */
    private $fechaEvaluacion;

    /**
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evaluado")
    * @ORM\JoinColumn(name="evaluado_id", referencedColumnName="id")
    */
    protected $evaluado;

    /**
      * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="evaluador")
      * @ORM\JoinColumn(name="evaluador_id", referencedColumnName="id")
      */
      protected $evaluador;

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
     * Set periodo
     *
     * @param integer $periodo
     * @return EvaluacionObrero
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
     * @return EvaluacionObrero
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

    /**
     * Set factoresEvaluacion1
     *
     * @param integer $factoresEvaluacion1
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion1($factoresEvaluacion1)
    {
        $this->factoresEvaluacion1 = $factoresEvaluacion1;

        return $this;
    }

    /**
     * Get factoresEvaluacion1
     *
     * @return integer 
     */
    public function getFactoresEvaluacion1()
    {
        return $this->factoresEvaluacion1;
    }

    /**
     * Set factoresEvaluacion2
     *
     * @param integer $factoresEvaluacion2
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion2($factoresEvaluacion2)
    {
        $this->factoresEvaluacion2 = $factoresEvaluacion2;

        return $this;
    }

    /**
     * Get factoresEvaluacion2
     *
     * @return integer 
     */
    public function getFactoresEvaluacion2()
    {
        return $this->factoresEvaluacion2;
    }

    /**
     * Set factoresEvaluacion3
     *
     * @param integer $factoresEvaluacion3
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion3($factoresEvaluacion3)
    {
        $this->factoresEvaluacion3 = $factoresEvaluacion3;

        return $this;
    }

    /**
     * Get factoresEvaluacion3
     *
     * @return integer 
     */
    public function getFactoresEvaluacion3()
    {
        return $this->factoresEvaluacion3;
    }

    /**
     * Set factoresEvaluacion4
     *
     * @param integer $factoresEvaluacion4
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion4($factoresEvaluacion4)
    {
        $this->factoresEvaluacion4 = $factoresEvaluacion4;

        return $this;
    }

    /**
     * Get factoresEvaluacion4
     *
     * @return integer 
     */
    public function getFactoresEvaluacion4()
    {
        return $this->factoresEvaluacion4;
    }

    /**
     * Set factoresEvaluacion5
     *
     * @param integer $factoresEvaluacion5
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion5($factoresEvaluacion5)
    {
        $this->factoresEvaluacion5 = $factoresEvaluacion5;

        return $this;
    }

    /**
     * Get factoresEvaluacion5
     *
     * @return integer 
     */
    public function getFactoresEvaluacion5()
    {
        return $this->factoresEvaluacion5;
    }

    /**
     * Set factoresEvaluacion6
     *
     * @param integer $factoresEvaluacion6
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion6($factoresEvaluacion6)
    {
        $this->factoresEvaluacion6 = $factoresEvaluacion6;

        return $this;
    }

    /**
     * Get factoresEvaluacion6
     *
     * @return integer 
     */
    public function getFactoresEvaluacion6()
    {
        return $this->factoresEvaluacion6;
    }

    /**
     * Set factoresEvaluacion7
     *
     * @param integer $factoresEvaluacion7
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion7($factoresEvaluacion7)
    {
        $this->factoresEvaluacion7 = $factoresEvaluacion7;

        return $this;
    }

    /**
     * Get factoresEvaluacion7
     *
     * @return integer 
     */
    public function getFactoresEvaluacion7()
    {
        return $this->factoresEvaluacion7;
    }

    /**
     * Set factoresEvaluacion8
     *
     * @param integer $factoresEvaluacion8
     * @return EvaluacionObrero
     */
    public function setFactoresEvaluacion8($factoresEvaluacion8)
    {
        $this->factoresEvaluacion8 = $factoresEvaluacion8;

        return $this;
    }

    /**
     * Get factoresEvaluacion8
     *
     * @return integer 
     */
    public function getFactoresEvaluacion8()
    {
        return $this->factoresEvaluacion8;
    }

    /**
     * Set factoresSupervision1
     *
     * @param integer $factoresSupervision1
     * @return EvaluacionObrero
     */
    public function setFactoresSupervision1($factoresSupervision1)
    {
        $this->factoresSupervision1 = $factoresSupervision1;

        return $this;
    }

    /**
     * Get factoresSupervision1
     *
     * @return integer 
     */
    public function getFactoresSupervision1()
    {
        return $this->factoresSupervision1;
    }

    /**
     * Set factoresSupervision2
     *
     * @param integer $factoresSupervision2
     * @return EvaluacionObrero
     */
    public function setFactoresSupervision2($factoresSupervision2)
    {
        $this->factoresSupervision2 = $factoresSupervision2;

        return $this;
    }

    /**
     * Get factoresSupervision2
     *
     * @return integer 
     */
    public function getFactoresSupervision2()
    {
        return $this->factoresSupervision2;
    }

    /**
     * Set factoresSupervision3
     *
     * @param integer $factoresSupervision3
     * @return EvaluacionObrero
     */
    public function setFactoresSupervision3($factoresSupervision3)
    {
        $this->factoresSupervision3 = $factoresSupervision3;

        return $this;
    }

    /**
     * Get factoresSupervision3
     *
     * @return integer 
     */
    public function getFactoresSupervision3()
    {
        return $this->factoresSupervision3;
    }

    /**
     * Set factoresSupervision4
     *
     * @param integer $factoresSupervision4
     * @return EvaluacionObrero
     */
    public function setFactoresSupervision4($factoresSupervision4)
    {
        $this->factoresSupervision4 = $factoresSupervision4;

        return $this;
    }

    /**
     * Get factoresSupervision4
     *
     * @return integer 
     */
    public function getFactoresSupervision4()
    {
        return $this->factoresSupervision4;
    }

    /**
     * Set comentarioDesempeno
     *
     * @param string $comentarioDesempeno
     * @return EvaluacionObrero
     */
    public function setComentarioDesempeno($comentarioDesempeno)
    {
        $this->comentarioDesempeno = $comentarioDesempeno;

        return $this;
    }

    /**
     * Get comentarioDesempeno
     *
     * @return string 
     */
    public function getComentarioDesempeno()
    {
        return $this->comentarioDesempeno;
    }

    /**
     * Set aspectosMejorar
     *
     * @param string $aspectosMejorar
     * @return EvaluacionObrero
     */
    public function setAspectosMejorar($aspectosMejorar)
    {
        $this->aspectosMejorar = $aspectosMejorar;

        return $this;
    }

    /**
     * Get aspectosMejorar
     *
     * @return string 
     */
    public function getAspectosMejorar()
    {
        return $this->aspectosMejorar;
    }

    /**
     * Set aspectosSignificativos
     *
     * @param string $aspectosSignificativos
     * @return EvaluacionObrero
     */
    public function setAspectosSignificativos($aspectosSignificativos)
    {
        $this->aspectosSignificativos = $aspectosSignificativos;

        return $this;
    }

    /**
     * Get aspectosSignificativos
     *
     * @return string 
     */
    public function getAspectosSignificativos()
    {
        return $this->aspectosSignificativos;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return EvaluacionObrero
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
     * Set fechaEvaluacion
     *
     * @param \DateTime $fechaEvaluacion
     * @return EvaluacionObrero
     */
    public function setFechaEvaluacion($fechaEvaluacion)
    {
        $this->fechaEvaluacion = $fechaEvaluacion;

        return $this;
    }

    /**
     * Get fechaEvaluacion
     *
     * @return \DateTime 
     */
    public function getFechaEvaluacion()
    {
        return $this->fechaEvaluacion;
    }

    /**
     * Set evaluado
     *
     * @param \cufm\SedaBundle\Entity\Usuario $evaluado
     * @return EvaluacionObrero
     */
    public function setEvaluado(\cufm\SedaBundle\Entity\Usuario $evaluado = null)
    {
        $this->evaluado = $evaluado;

        return $this;
    }

    /**
     * Get evaluado
     *
     * @return \cufm\SedaBundle\Entity\Usuario 
     */
    public function getEvaluado()
    {
        return $this->evaluado;
    }

    /**
     * Set evaluador
     *
     * @param \cufm\SedaBundle\Entity\Usuario $evaluador
     * @return EvaluacionObrero
     */
    public function setEvaluador(\cufm\SedaBundle\Entity\Usuario $evaluador = null)
    {
        $this->evaluador = $evaluador;

        return $this;
    }

    /**
     * Get evaluador
     *
     * @return \cufm\SedaBundle\Entity\Usuario 
     */
    public function getEvaluador()
    {
        return $this->evaluador;
    }

    /**
     * Set observacionOGTH
     *
     * @param string $observacionOGTH
     * @return EvaluacionObrero
     */
    public function setObservacionOGTH($observacionOGTH)
    {
        $this->observacionOGTH = $observacionOGTH;

        return $this;
    }

    /**
     * Get observacionOGTH
     *
     * @return string 
     */
    public function getObservacionOGTH()
    {
        return $this->observacionOGTH;
    }
}
