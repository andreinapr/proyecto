<?php

namespace cufm\SedaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Usuario;
use cufm\SedaBundle\Form\UsuariocrearType;
use cufm\SedaBundle\Form\UsuarioeditarType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends Controller
{
    public function indexAction()
    {
     	$repositorio =$this->getDoctrine()->getRepository('SedaBundle:Usuario');

     	$usuarios = $repositorio->findAll();

        return $this->render('SedaBundle:Usuario:index.html.twig', array('usuarios' => $usuarios ));
    }

    public function crearAction()
    {
        $usuario = new Usuario();
        $formulario = $this->createForm(new UsuarioCrearType(), $usuario);


        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()){
           
                $data = $formulario->getData();
                $username = $data->getUsername();
                $password = $data->getPassword();

                // se valida si el usuario ya exite
                $consulta = $em->createQuery('SELECT u FROM SedaBundle:Usuario u WHERE u.username= :username')
                                ->setParameters(array('username' => $username));
                $usuario_existente = $consulta->getResult();

                if ($usuario_existente) {
                    $error = 'Este usuario ya existe';
                }else{
                    $error = 0;
                }

                if (!$error) {  
                    
                        $factory = $this->get('security.encoder_factory');
                        $encoder = $factory->getEncoder($usuario);
                        $pass = $encoder->encodePassword($password,$usuario->getSalt());
                        $usuario->setPassword($pass);
                    }

            $em->persist($usuario);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_index'));
        }

        return $this->render(
                            'SedaBundle:Usuario:crear.html.twig',
                            array('formulario' => $formulario->createView())
                            );

    }

    public function editarAction($usuario_id)
    {
    	$em = $this->getDoctrine()->getManager();
        if ($usuario_id) {
            $usuario = $em->getRepository('SedaBundle:Usuario')->find($usuario_id);
            $error = '';
        } else {
            // mensaje de error 
            $error = 'Este usuario no existe';
        }

        $formulario = $this->createForm(new UsuarioEditarType(), $usuario);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);
            
        //ld($formulario->isValid());
        if ($formulario->isValid()){
          
            $em->persist($usuario);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_index'));
        }



        return $this->render('SedaBundle:Usuario:editar.html.twig',
        					array('usuario' => $usuario,
        						'formulario' => $formulario->createView(),
        						'error' => $error ? $error : ''
        						));
    }

 public function claveAction($usuario_id)
    {
      
        $em = $this->getDoctrine()->getManager();
      
        $usuario = $em->getRepository('SedaBundle:Usuario')->find($usuario_id);

        $formulario = $this->createFormBuilder($usuario)
            ->add('password', 'password', array('always_empty' => true))
            ->getForm();

        $peticion = $this->getRequest();
	    $formulario->handleRequest($peticion);

	   if ($formulario->isValid()){

            $data = $formulario->getData();
            $password = $data->getPassword();
              
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($usuario);
            $pass = $encoder->encodePassword($password, $usuario->getSalt());
            $usuario->setPassword($pass);

            $em->persist($usuario);
            $em->flush();

          
            if (!$this->get('security.context')->isGranted('ROLE_OGTH')) {
                return $this->redirect($this->generateUrl('Seda_homepage'));
            }else{
                return $this->redirect($this->generateUrl('usuario_index'));

            }
            
        }

      return $this->render('SedaBundle:Usuario:clave.html.twig', 
                           array ('usuario' => $usuario,
                                  'formulario' => $formulario->createView()
                                  )
                           );

    }
    
}
