<?php

namespace cufm\SedaBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use cufm\SedaBundle\Entity\EvaluacionObrero;
use cufm\SedaBundle\Form\EvaluacionObreroType;
use cufm\SedaBundle\Form\ElegirEvaluacionObreroType;
use cufm\SedaBundle\Form\EditarEvaluacionObreroType;

/**
 * EvaluacionObrero controller.
 *
 */
class EvaluacionObreroController extends Controller
{

    /**
     * Lists all EvaluacionObrero entities.
     *
 
     */
    public function indexAction()
    {
/*  
        $em = $this->getDoctrine()->getManager();

        $evaluaciones = $em->getRepository('SedaBundle:EvaluacionObrero')->findAll();

              return $this->render('SedaBundle:EvaluacionObrero:index.html.twig',
                                    array('evaluaciones' => $evaluaciones,
                                          //'usuario' => $usuario
                                      ));
*/
            $supervisa = $this->getUser()->getSupervisa();

            //ld($supervisa);
            $usuario = $this->getUser();

            //ld($usuario);
            $em = $this->getDoctrine()->getManager();
    
            //MUESTRA LOS EVALUACIONES DE LOS SUPERVISADOS DEL USUARIO QUE SE LOGUEA
            $query = $em->createQuery("SELECT o FROM SedaBundle:EvaluacionObrero o  WHERE  o.evaluador = :supervisa");
            $query->setParameter('supervisa', $usuario);
            $evaluaciones = $query->getResult();

        //ld($evaluaciones);
              return $this->render('SedaBundle:EvaluacionObrero:index.html.twig',
                                    array('evaluaciones' => $evaluaciones,
                                          'usuario' =>  $usuario
                                      ));              
    }


    public function crearAction()
    {

        $evaluacion = new EvaluacionObrero();

        $supervisa = $this->getUser()->getSupervisa();
        $formulario = $this->createForm(new EvaluacionObreroType($supervisa), $evaluacion);
        
        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);    

        $error = '';
        if ($formulario->isValid()){

            
          // Validando que no exitan Odis antes de Guardar en Nuevo
            $usuario_id = $evaluacion->getEvaluado()->getId();
            $periodo = $evaluacion->getPeriodo();
            $ano = $evaluacion->getAno();

            $repository = $this->getDoctrine()
                ->getRepository('SedaBundle:EvaluacionObrero');

            $query = $repository->createQueryBuilder('o')
                ->where('o.evaluado = :usuario AND o.periodo = :periodo AND o.ano = :ano')
                ->setParameters(array('usuario' => $usuario_id,
                                      'periodo' => $periodo,
                                      'ano' => $ano,
                                    ))
                ->getQuery();

            $consulta = $query->getResult();

            if (!$consulta) {

            $evaluacion->SetEvaluador($this->getUser());

            $evaluacion->setfechaEvaluacion(new \DateTime('now'));


            //ld($evaluacion);
            //ldd($formulario->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluacion);
            $em->flush();

            return $this->redirect($this->generateUrl('Seda_evaluacionObrero'));

                return $this->redirect($this->generateUrl('Seda_odis_lista'));

            }else{
                $error = 'Ya Exiten O.D.I. Definidos para '.$evaluacion->getEvaluado().' en el Semestre '.$periodo.' del año '.$ano;
            }
        }


        return $this->render('SedaBundle:EvaluacionObrero:new.html.twig',
                            array('formulario' => $formulario->createView(),
                                 'evaluacion' => $evaluacion,
                                 'error' => $error
                                 ));
    }

    public function elegirAction()
    {

        $evaluacion = new EvaluacionObrero();
        $supervisa = $this->getUser()->getSupervisa();
        $formularioelegir = $this->createForm(new ElegirEvaluacionObreroType($supervisa), $evaluacion);

        $peticion = $this->getRequest();
        $formularioelegir->handleRequest($peticion);
        $error ='';

        if ($formularioelegir->isValid()){
            $data = $formularioelegir->getData();
            $evaluado = $data->getEvaluado()->getId();
            $periodo = $data->getPeriodo();
            $ano = $data->getAno();

            //ld($data);

            $repository = $this->getDoctrine()
                ->getRepository('SedaBundle:EvaluacionObrero');

            $query = $repository->createQueryBuilder('o')
                ->where('o.evaluado = :evaluado AND o.periodo = :periodo AND o.ano = :ano')
                ->setParameters(array('evaluado' => $evaluado,
                                      'periodo' => $periodo,
                                      'ano' => $ano,
                                    ))
                ->getQuery();

            $consultaevaluacion = $query->getResult();

            //ldd($consultaevaluacion[0]);
            if (!$consultaevaluacion) {
                $error = 'No Exiten Evaluacion definida para '.$data->getEvaluado().' en el Semestre '.$periodo.' del año '.$ano;

            }else{
                $id = $consultaevaluacion[0]->getId();
                 return $this->redirect($this->generateUrl('Seda_evaluacionObrero_editar', array('id' => $id)));
             }




        }

        return $this->render('SedaBundle:EvaluacionObrero:elegirEvaluacionObrero.html.twig',
                            array('formularioelegir' => $formularioelegir->createView(),
                                  'error' => $error
                                ));

    }


    public function editarAction($id)
    {

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');
        //ld($id);
        $evaluacionresult = $repositorio->findById($id);
        $evaluacion = $evaluacionresult[0];
        //ldd($evaluacion);

        $supervisa = $this->getUser()->getSupervisa();
        $formulario = $this->createForm(new EditarEvaluacionObreroType($supervisa), $evaluacion);


            $peticion = $this->getRequest();
            $formulario->handleRequest($peticion);


            if ($formulario->isValid()){
                //ldd($formulario->getData());


                $em = $this->getDoctrine()->getManager();


                $em->persist($evaluacion);
                $em->flush();

                 return $this->redirect($this->generateUrl('Seda_evaluacionObrero')); 
            }


            return $this->render('SedaBundle:EvaluacionObrero:edit.html.twig',
                                array('formulario' => $formulario->createView()
                                     ,'evaluacion' => $evaluacion
                                     //,'error' => $error

                                     ));

    }

    public function listarAction($eliminado)
    {

            //$eliminado =' ';
            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');

            $evaluaciones = $repositorio->findAll();

        return $this->render('SedaBundle:EvaluacionObrero:List.html.twig',
                             array('evaluaciones' => $evaluaciones,
                                   'eliminado' => $eliminado
                                ));
    }


    public function eliminarAction($id)
    {

        if (!$id)  {
            return $this->redirect($this->generateUrl('Seda_evaluacionObrero_listar'));
        }

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');

        $consulta = $repositorio->find($id);




        if ($consulta->getPeriodo() == 1) {
            $periodo = '1er. Semestre';
        }else{
            $periodo = '2do. Semestre';
        }

        $eliminado = 'Se Elimino La Evaluacion del funcionario '.$consulta->getEvaluado().' del periodo '.$periodo.' del año '.$consulta->getAno();
        //ld($eliminado);
        //ldd($consulta);
          $em = $this->getDoctrine()->getManager();
           $em->remove($consulta);
           $em->flush();



    return $this->redirect($this->generateUrl('Seda_evaluacionObrero_listar', array('eliminado' => $eliminado)));
    
    }

    public function mostrarAction($id)
    {
        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');
        $evaluacion = $repositorio->find($id);
        

        $formulario = $this->createFormBuilder($evaluacion)
            ->add('observacionOGTH', 'textarea', array('required'=>false))        
            ->getForm();

        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
            //ldd($evaluacion);
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluacion);
            $em->flush();

           return $this->redirect($this->generateUrl('Seda_evaluacionObrero'));
        }


        return $this->render('SedaBundle:EvaluacionObrero:show.html.twig',
                                array('evaluacion' => $evaluacion,
                                      'formulario' => $formulario->createView()
                                     ));

    }

    public function pdfAction($id)
        {

            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');

            $evaluacion = $repositorio->find($id);

            $nombres = $evaluacion->getEvaluado()->getNombres();

            $apellidos = $evaluacion->getEvaluado()->getApellidos();

            $periodo = $evaluacion->getPeriodo();

            $ano = $evaluacion->getAno();

            //ldd($evaluacion);

 /*   
            return $this->render('SedaBundle:EvaluacionObrero:pdf.html.twig',
                                  array('evaluacion' => $evaluacion)
                               );
*/
    
  
            $html = $this->renderView('SedaBundle:EvaluacionObrero:pdf.html.twig', array(
                'evaluacion'  => $evaluacion
            ));


            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                                       array('orientation'=>'Portrait',
                                             'default-header'=>false)),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="Evaluacion-'.$apellidos.' '.$nombres.'-'.$periodo.'-'.$ano.'.pdf"'
                )
            );
  
        }

}
