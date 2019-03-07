<?php

namespace cufm\SedaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Cargo;
use cufm\SedaBundle\Form\CargoType;


class CargoController extends Controller
{

    public function indexAction($eliminado)
    {

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Cargo');
        $cargos = $repositorio->findAll();       

      return $this->render('SedaBundle:Cargo:index.html.twig',
                            array('cargos' => $cargos,
                                    'eliminado' => $eliminado
                                )
                         );
    }

    public function crearCargoAction()
    {

        $cargo = new Cargo();
        //ld(new CargoType());
        //ldd($cargo);
        $formulario = $this->createForm(new CargoType(), $cargo);
        
        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);    

        if ($formulario->isValid()){

            $em = $this->getDoctrine()->getManager();
            // Verificacion de la exitenia del cargo antes de crearla
            $denominacion = $formulario->getData()->getDenominacion(); 
            $consulta=$em->getRepository('SedaBundle:Cargo')->findByDenominacion($denominacion);

            if (!$consulta) {
                $em->persist($cargo);
                $em->flush();
                $eliminado='';
            } else {
                // mensaje de error 
                $eliminado = 'El cargo '.$denominacion.' ya exite';
            }

            return $this->redirect($this->generateUrl('Seda_cargos_index', array('eliminado' => $eliminado)));
        }

        return $this->render('SedaBundle:Cargo:crearCargo.html.twig',
                            array('formulario' => $formulario->createView(),
                                 'cargo' => $cargo
                                 ));
    }

    public function editarCargoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $cargo = $em->getRepository('SedaBundle:Cargo')->find($id);
            $error = '';
        } else {
            // mensaje de error 
            $error = 'Cargo no exite';
        }

        $formulario = $this->createForm(new CargoType(), $cargo);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);
            
        if ($formulario->isValid()){
          
            $em->persist($cargo);
            $em->flush();

            return $this->redirect($this->generateUrl('Seda_cargos_index'));
        }



        return $this->render('SedaBundle:Cargo:editarCargo.html.twig',
                            array('formulario' => $formulario->createView(),
                                'cargo' => $cargo,
                                'error' => $error ? $error : ''
                                ));
    }

    public function eliminarCargoAction($id)
    {
        if (!$id)  {
            return $this->redirect($this->generateUrl('Seda_cargos_index'));
        }

       $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Cargo');

       $consulta = $repositorio->find($id);

      
       $eliminado = 'Se Elimino la cargo: '.$consulta->getdenominacion();

       $em = $this->getDoctrine()->getManager();
       $em->remove($consulta);
       $em->flush();

    return $this->redirect($this->generateUrl('Seda_cargos_index', array('eliminado' => $eliminado)));
    }
}
