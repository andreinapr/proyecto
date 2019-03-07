<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
* @ORM\Table(name="roles")
*/
class Role implements RoleInterface
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;
	
	/**
	* @ORM\Column(name="name", type="string", length=30)
	*/
	private $name;

	/**
	* @ORM\Column(name="role", type="string", length=20, unique=true)
	*/
	private $role;

	/**
	* @ORM\ManyToMany(targetEntity="Usuario", mappedBy="roles")
	*/
	private $usuarios;
	
	public function __construct()
	{
		$this->usuarios = new ArrayCollection();
	}

    public function __toString() //Metodo Majico
    {

       return $this->getName();
    } 

	/**
	* @see RoleInterface
	*/
	public function getRole()
	{
		return $this->role;
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
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add usuarios
     *
     * @param \cufm\SedaBundle\Entity\Usuario $usuarios
     * @return Role
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
}
