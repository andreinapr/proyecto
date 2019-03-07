<?php

namespace cufm\SedaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Dependencia;
use cufm\SedaBundle\Form\DependenciaType;

class DependenciaController extends Controller
{

    public function indexAction($eliminado)
    {

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Dependencia');
        $dependencias = $repositorio->findAll();       

      return $this->render('SedaBundle:Dependencia:index.html.twig',
                            array('dependencias' => $dependencias,
                                    'eliminado' => $eliminado
                                )
                         );
    }

    public function crearDependenciaAction()
    {

        $dependencia = new Dependencia();
        $formulario = $this->createForm(new DependenciaType(), $dependencia);
        
        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);    

        if ($formulario->isValid()){

            $em = $this->getDoctrine()->getManager();

            // Verificacion de la exitenia de la dependencia antes de crearla
            $denominacion = $formulario->getData()->getDenominacion(); 
            $consulta=$em->getRepository('SedaBundle:Dependencia')->findByDenominacion($denominacion);

            if (!$consulta) {
                $em->persist($dependencia);
                $em->flush();
                $eliminado='';
            } else {
                // mensaje de error 
                $eliminado = 'La Dependencia '.$denominacion.' ya exite';
            }

            return $this->redirect($this->generateUrl('Seda_dependencias_index', array('eliminado' => $eliminado)));  
        }

        return $this->render('SedaBundle:Dependencia:crearDependencia.html.twig',
                            array('formulario' => $formulario->createView(),
                                 'dependencia' => $dependencia
                                 ));
    }

    public function editarDependenciaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $dependencia = $em->getRepository('SedaBundle:Dependencia')->find($id);
            $error = '';
        } else {
            // mensaje de error 
            $error = 'Dependencia no exite';
        }

        $formulario = $this->createForm(new DependenciaType(), $dependencia);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);
            
        if ($formulario->isValid()){
          
            $em->persist($dependencia);
            $em->flush();

            return $this->redirect($this->generateUrl('Seda_dependencias_index'));
        }



        return $this->render('SedaBundle:Dependencia:editarDependencia.html.twig',
                            array('formulario' => $formulario->createView(),
                                'dependencia' => $dependencia,
                                'error' => $error ? $error : ''
                                ));
    }

    public function eliminarDependenciaAction($id)
    {
        if (!$id)  {
            return $this->redirect($this->generateUrl('Seda_dependencias_index'));
        }

       $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Dependencia');

       $consulta = $repositorio->find($id);

      
       $eliminado = 'Se Elimino la dependencia: '.$consulta->getdenominacion();

       $em = $this->getDoctrine()->getManager();
       $em->remove($consulta);
       $em->flush();

    return $this->redirect($this->generateUrl('Seda_dependencias_index', array('eliminado' => $eliminado)));
    }
}
