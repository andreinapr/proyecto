<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="dependencias")
 */
class Dependencia
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $denominacion;

    /**
     * @ORM\Column(type="string", length=6)
     */
    protected $iniciales;

    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $codigo;

    /**
    * @ORM\OneToMany(targetEntity="Usuario", mappedBy="dependencia")
    */
    protected $usuarios;

    /**
    * @ORM\OneToMany(targetEntity="Odi", mappedBy="dependencia")
    */
    protected $odis;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
     protected $activo;    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Dependencia
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
     * Set iniciales
     *
     * @param string $iniciales
     * @return Dependencia
     */
    public function setIniciales($iniciales)
    {
        $this->iniciales = $iniciales;

        return $this;
    }

    /**
     * Get iniciales
     *
     * @return string
     */
    public function getIniciales()
    {
        return $this->iniciales;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Dependencia
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Add usuarios
     *
     * @param \cufm\SedaBundle\Entity\Usuario $usuarios
     * @return Dependencia
     */
    public function addUsuario(\cufm\SedaBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \cufm\SedaBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\cufm\SedaBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Add odis
     *
     * @param \cufm\SedaBundle\Entity\Odi $odis
     * @return Dependencia
     */
    public function addOdi(\cufm\SedaBundle\Entity\Odi $odis)
    {
        $this->odis[] = $odis;

        return $this;
    }

    /**
     * Remove odis
     *
     * @param \cufm\SedaBundle\Entity\Odi $odis
     */
    public function removeOdi(\cufm\SedaBundle\Entity\Odi $odis)
    {
        $this->odis->removeElement($odis);
    }

    /**
     * Get odis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOdis()
    {
        return $this->odis;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Dependencia
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
