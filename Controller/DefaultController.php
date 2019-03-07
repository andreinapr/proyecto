<?php

namespace cufm\SedaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SedaBundle:Default:index.html.twig');
    }

	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();

		$request->setLocale('es_VE');

		// obtiene el error de inicio de sesión si lo hay
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		}
		else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		$t = '';
		if ($error) {
			$t = 'Correo o Contraseña Incorrecta';
			//$t = $this->get('translator')->trans($error->getMessage());
			//$t = $error->getMessage();
		}

	
		return $this->render('SedaBundle:Default:login.html.twig', array(
																				// el último nombre de usuario ingresado por el usuario
																				'last_username' => $session->get(SecurityContext::LAST_USERNAME),
																				'error' => $t,
																				));
	}

	public function evaluacionAction(Request $request)
	{


        $appDir = $this->container->getParameter('kernel.root_dir');
        $configuracion = Yaml::parse($appDir.'/config/parametros.yml');

        $evaluacion = $configuracion['parameters']['evaluacion'];

		$data = array('evaluacion' => $evaluacion);



        $formulario = $this->createFormBuilder($data)
			->add('evaluacion','choice', array('choices' => array('1' =>'Activo',
                                                                  '0' =>'Inactivo'),
                                            	'expanded' => true,
                                           		'multiple' => false))    
            ->getForm();

        //ld($configuracion);
        //ld($evaluacion);
        //ldd($formulario);

        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
        	$config = $formulario->getData();
            
            $configuracion['parameters']['evaluacion'] = $config['evaluacion'];

            //ldd($configuracion['parameters']['evaluacion']);

			file_put_contents(
			    $appDir.'/config/parametros.yml',
			    Yaml::dump($configuracion)
			);
        // Seteando valor en session
        $session = $request->getSession();
        $session->set('evaluacion', $config['evaluacion']);

           return $this->redirect($this->generateUrl('Seda_odis_index'));
        }		


        return $this->render('SedaBundle:Default:evaluacion.html.twig',
                                array('formulario' => $formulario->createView()
                                     ));
	}

}
