<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cargos")
 */
class Cargo
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
    * @ORM\OneToMany(targetEntity="Usuario", mappedBy="cargo")
    */
    protected $usuarios;

    /**
    * @ORM\OneToMany(targetEntity="Odi", mappedBy="cargo")
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
     * @return Cargo
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
     * Add usuarios
     *
     * @param \cufm\SedaBundle\Entity\Usuario $usuarios
     * @return Cargo
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
     * @return Cargo
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
     * @return Cargo
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
