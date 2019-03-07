<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="cufm\SedaBundle\Entity\UsuarioRepository")
 * @ORM\Table(name="usuarios")
 */
class Usuario implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(type="string", length=100)
     *
     */
    protected $nombres;

    /**
     * @ORM\Column(type="string", length=100)
     *
     */
    protected $apellidos;

	/**
	 * @ORM\Column(type="integer", length=10)
     *
 	 */
    protected $cedula;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    protected $supervisor;

    /**
	 * @ORM\ManyToOne(targetEntity="Dependencia", inversedBy="usuarios")
	 * @ORM\JoinColumn(name="supervisada_id", referencedColumnName="id")
     *
	 */
	protected $supervisa;

    /**
     * @ORM\ManyToOne(targetEntity="Dependencia", inversedBy="usuarios")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id")
     *
     */
    protected $dependencia;

    /**
	  * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="usuarios")
	  * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id")
	  *
	  */
	  protected $cargo;

    /**
     * @ORM\Column(name="nivel", type="integer")
     */
     private $nivel;

    /**
    * @ORM\OneToMany(targetEntity="Odi", mappedBy="usuario")
    */
    protected $odis;

    /**
    * @ORM\OneToMany(targetEntity="Odi", mappedBy="usuario")
    */
    protected $creador;    

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
    * @ORM\ManyToMany(targetEntity="Role", inversedBy="usuarios")
    */
    private $roles;

    /**
     * @ORM\Column(type="smallint")
     *
     */
    protected $tipoPersonal;



    public function __toString() //Metodo Majico
     {
        $nom = $this->getNombres();
        $ape = $this->getApellidos();
        $apenom = $ape.', '.$nom;
       return $apenom;
     }

    /**
     * Constructor
     */
    public function __construct()
    {
        //parent::__construct();
        $this->odis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->evaluaciones = new \Doctrine\Common\Collections\ArrayCollection();

        $this->isActive = true;
        $this->supervisor = false;
        $this->salt = md5($this->username);
        $this->roles = new ArrayCollection();

    }

    /**
    * @inheritDoc
    */
    public function getRoles()
    {
        return $this->roles->toArray();
    }
    /**
    * @inheritDoc
    */
    public function eraseCredentials()
    {

    }

    /**
    * @inheritDoc
    */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    /**
    * @see \Serializable::serialize()
    */
    public function serialize()
    {
        return serialize(array(
        $this->id,
        ));
    }


    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
    * @see \Serializable::unserialize()
    */
    public function unserialize($serialized)
    {
        list (
        $this->id,
        ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
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
     * Set nombres
     *
     * @param string $nombres
     * @return Usuario
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Usuario
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set cedula
     *
     * @param integer $cedula
     * @return Usuario
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return integer
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set supervisor
     *
     * @param boolean $supervisor
     * @return Usuario
     */
    public function setSupervisor($supervisor)
    {
        $this->supervisor = $supervisor;

        return $this;
    }

    /**
     * Get supervisor
     *
     * @return boolean
     */
    public function getSupervisor()
    {
        return $this->supervisor;
    }


    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Usuario
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }


    /**
     * Set supervisa
     *
     * @param \cufm\SedaBundle\Entity\Dependencia $supervisa
     * @return Usuario
     */
    public function setSupervisa(\cufm\SedaBundle\Entity\Dependencia $supervisa = null)
    {
        $this->supervisa = $supervisa;

        return $this;
    }

    /**
     * Get supervisa
     *
     * @return \cufm\SedaBundle\Entity\Dependencia
     */
    public function getSupervisa()
    {
        return $this->supervisa;
    }

    /**
     * Set dependencia
     *
     * @param \cufm\SedaBundle\Entity\Dependencia $dependencia
     * @return Usuario
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
     * @return Usuario
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
     * Add odis
     *
     * @param \cufm\SedaBundle\Entity\Odi $odis
     * @return Usuario
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
     * Add roles
     *
     * @param \cufm\SedaBundle\Entity\Role $roles
     * @return Usuario
     */
    public function addRole(\cufm\SedaBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
        $roles->addUsuario($this);

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \cufm\SedaBundle\Entity\Role $roles
     */
    public function removeRole(\cufm\SedaBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return Usuario
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set docente
     *
     * @param boolean $docente
     * @return Usuario
     */
    public function setDocente($docente)
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * Get docente
     *
     * @return boolean
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Add creador
     *
     * @param \cufm\SedaBundle\Entity\Odi $creador
     * @return Usuario
     */
    public function addCreador(\cufm\SedaBundle\Entity\Odi $creador)
    {
        $this->creador[] = $creador;

        return $this;
    }

    /**
     * Remove creador
     *
     * @param \cufm\SedaBundle\Entity\Odi $creador
     */
    public function removeCreador(\cufm\SedaBundle\Entity\Odi $creador)
    {
        $this->creador->removeElement($creador);
    }

    /**
     * Get creador
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Set tipoPersonal
     *
     * @param integer $tipoPersonal
     * @return Usuario
     */
    public function setTipoPersonal($tipoPersonal)
    {
        $this->tipoPersonal = $tipoPersonal;

        return $this;
    }

    /**
     * Get tipoPersonal
     *
     * @return integer 
     */
    public function getTipoPersonal()
    {
        return $this->tipoPersonal;
    }
}
