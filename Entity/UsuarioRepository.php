<?php

namespace cufm\SedaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Entity\Usuario;

class UsuarioRepository extends EntityRepository
{
	public function usuariosSupervisados($supervisa)
	{

	    $consulta = $this->getManager()->createQuery('SELECT e FROM SedaBundle:Usuario e 
	    												WHERE e.dependencia_id = :supervisa ')
													->setParameters(array('supervisa' => $supervisa));
    return $consulta->getResult();
	}
}