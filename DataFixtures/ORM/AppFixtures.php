<?php
namespace cufm\SedaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;
use cufm\SedaBundle\Entity\Usuario;
use cufm\SedaBundle\Util\Util;

class AppFixtures extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/cargos.yml',
            __DIR__ . '/competencias.yml',
            __DIR__ . '/dependencias.yml',
            __DIR__ . '/roles.yml',
            __DIR__ . '/usuarios.yml',
        );
    }

    public function encodePassword(Usuario $usuario, $plainPassword)
    {
        /** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $encoder */
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($usuario)
        ;

        return $encoder->encodePassword($plainPassword, $usuario->getSalt());
    }

    public function generarCorreo(Usuario $usuario)
        {

            $nombrel = Util::limpiar($usuario->getNombres());
            $apellidol = Util::limpiar($usuario->getApellidos());

            $nombrem = strtolower($nombrel);
            $apellidom = strtolower($apellidol);                

            $nombre = explode(' ',$nombrem);
            $apellido = explode(' ',$apellidom);

            $correo = $nombre[0].'.'.$apellido[0].'@cufm.tec.ve';

            return $correo;
        }    
}