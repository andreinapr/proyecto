<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="evaluaciones_competencias")
 */
class EvaluacionCompetencia
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
    protected $peso;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rango;

    /**
     * @ORM\Column(type="integer")
     */
    protected $pesoxrango;

    /**
    * @ORM\ManyToOne(targetEntity="Competencia", inversedBy="competencias", cascade={"persist"})
    * @ORM\JoinColumn(name="competencias_id", referencedColumnName="id")
    */
    protected $competencia;

    /**
     * @ORM\ManyToOne(targetEntity="Odi", inversedBy="evalcompetencia", cascade={"persist"})
     * @ORM\JoinColumn(name="odi_id", referencedColumnName="id")
     **/
    private $odi;


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
     * Set peso
     *
     * @param integer $peso
     * @return EvaluacionCompetencia
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
     * Set rango
     *
     * @param integer $rango
     * @return EvaluacionCompetencia
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
     * @return EvaluacionCompetencia
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
     * Set competencia
     *
     * @param \cufm\SedaBundle\Entity\Competencia $competencia
     * @return EvaluacionCompetencia
     */
    public function setCompetencia(\cufm\SedaBundle\Entity\Competencia $competencia = null)
    {
        $this->competencia = $competencia;

        return $this;
    }

    /**
     * Get competencia
     *
     * @return \cufm\SedaBundle\Entity\Competencia 
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set odi
     *
     * @param \cufm\SedaBundle\Entity\Odi $odi
     * @return EvaluacionCompetencia
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
}
