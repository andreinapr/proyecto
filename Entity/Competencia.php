<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="competencias")
 */
class Competencia
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
    protected $descripcion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $tipo;
    
    /**
    * @ORM\OneToMany(targetEntity="EvaluacionCompetencia", mappedBy="competencia", cascade={"persist"})
    */
    protected $competencias;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->competencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() //Metodo Majico
    {

       return $this->getDescripcion();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Competencia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }


    /**
     * Set tipo
     *
     * @param boolean $tipo
     * @return Competencia
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return boolean 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    //OJO  borrar las funciones addCompetencias y removeCompetencias

    public function setCompetencias(\Doctrine\Common\Collections\Collection $competencias)
    {
        $this->competencias = $competencias;
        foreach ($competencias as $competencia) {
            $competencia->setCompetencia($this);
        }
    }

    /**
     * Get competencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCompetencias()
    {
        return $this->competencias;
    }


    /**
     * Add competencias
     *
     * @param \cufm\SedaBundle\Entity\EvaluacionCompetencia $competencias
     * @return Competencia
     */
    public function addCompetencia(\cufm\SedaBundle\Entity\EvaluacionCompetencia $competencias)
    {
        $this->competencias[] = $competencias;

        return $this;
    }

    /**
     * Remove competencias
     *
     * @param \cufm\SedaBundle\Entity\EvaluacionCompetencia $competencias
     */
    public function removeCompetencia(\cufm\SedaBundle\Entity\EvaluacionCompetencia $competencias)
    {
        $this->competencias->removeElement($competencias);
    }
}
