<?php

namespace cufm\SedaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Observacion;
use cufm\SedaBundle\Entity\Odi;
use cufm\SedaBundle\Form\ObservacionType;
use cufm\SedaBundle\Form\RevisionOdiType;

class ObservacionController extends Controller
{
    public function indexAction($eliminado)
    {

		$repositorio = $this->getDoctrine()->getRepository('SedaBundle:Observacion');
    	$observaciones = $repositorio->findAll();    	

      return $this->render('SedaBundle:Observacion:index.html.twig',
                            array('observaciones' => $observaciones,
                                    'eliminado' => $eliminado
                                )
                         );
    }

    public function crearObservacionAction()
    {

    	$observacion = new Observacion();
		$formulario = $this->createForm(new ObservacionType(), $observacion);
		
		$peticion = $this->getRequest();
        $formulario->handleRequest($peticion);    

		if ($formulario->isValid()){

			$em = $this->getDoctrine()->getManager();
            $em->persist($observacion);
            $em->flush();

            return $this->redirect($this->generateUrl('Seda_observaciones_index'));  
		}

		return $this->render('SedaBundle:Observacion:crearObservacion.html.twig',
							array('formulario' => $formulario->createView(),
                                 'observacion' => $observacion
                                 ));
    }

    public function editarObservacionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $observacion = $em->getRepository('SedaBundle:Observacion')->find($id);
            $error = '';
        } else {
            // mensaje de error 
            $error = 'Observacion no exite';
        }

        $formulario = $this->createForm(new ObservacionType(), $observacion);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);
            
        if ($formulario->isValid()){
          
            $em->persist($observacion);
            $em->flush();

            return $this->redirect($this->generateUrl('Seda_observaciones_index'));
        }



        return $this->render('SedaBundle:Observacion:editarObservacion.html.twig',
                            array('formulario' => $formulario->createView(),
                                'observacion' => $observacion,
                                'error' => $error ? $error : ''
                                ));
    }

    public function eliminarObservacionAction($id)
    {
        if (!$id)  {
            return $this->redirect($this->generateUrl('Seda_observaciones_index'));
        }

       $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Observacion');

       $consulta = $repositorio->find($id);

      
       $eliminado = 'Se Elimino la observacion '.$consulta->getdenominacion();

       $em = $this->getDoctrine()->getManager();
       $em->remove($consulta);
       $em->flush();

    return $this->redirect($this->generateUrl('Seda_observaciones_index', array('eliminado' => $eliminado)));
    }

    public function revisionListarAction()
    {

        $em = $this->getDoctrine()->getManager();          
        //ORDERNAD ODIS POR DEPENDENCIA DEL FUNCIONARIO
        $query = $em->createQuery('SELECT o FROM SedaBundle:Odi o INNER JOIN SedaBundle:Usuario u 
                                    WHERE  o.usuario = u.id  AND o.evaluacion is empty
                                    ORDER BY  o.periodo DESC, o.ano ASC ');

        $odis = $query->getResult();        
        //ld($odis[0]->getEvaluacion()->isEmpty());
        //ld($odis);
              return $this->render('SedaBundle:Observacion:revisionListar.html.twig',
                                    array('odis' => $odis)
                                 );
    }

    public function revisionAction($id)
    {
        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

        $odi = $repositorio->find($id);                           
        //ld($odi);

            $formulario = $this->createForm(new RevisionOdiType(), $odi);  

                    
            $peticion = $this->getRequest();
            $formulario->handleRequest($peticion);

            
            if ($formulario->isValid()){
              
                $em = $this->getDoctrine()->getManager();
                /**
                 * 1 eliminar todos las observaciones de cada objetivo
                 */
                //$objs = $this->getDoctrine()->getRepository('SedaBundle:Odi');
                //ld($odi->getObjetivos()->get(1)->getObservaciones()->toArray());
                //ldd($odi->getObjetivos()->get(0)->getObservaciones()->count());
                
                $total_obs = $this->getDoctrine()->getRepository('SedaBundle:Observacion')->findAll();
                for ($obj=0; $obj < $odi->getObjetivos()->count(); $obj++) { 
                    if ($odi->getObjetivos()->get($obj)->getObservaciones()->toArray() == 0) {
                        for ($obs=1; $obs <= count($total_obs); $obs++) { 
                            $items = $this->getDoctrine()->getRepository('SedaBundle:Observacion')->find($obs);
                            
                            $odi->getObjetivos()->get($obj)->removeObservacione($items);                                        
                        }
                    }
                }

                
                if ($odi->getVbogth() == true) {
                    $hoy = new \DateTime('now');
                    $odi->setFechaVbogth($hoy);
                }
              

                /*
                if (is_null($obs)) {


                    $odi->getObjetivos()->get(0)->removeObservacione($items);
                    //$em->remove($obs);
                }  */   
             
                $em->persist($odi);
                $em->flush();

                return $this->redirect($this->generateUrl('Seda_observaciones_revision_listar'));
            }


            return $this->render('SedaBundle:Observacion:revisionOdi.html.twig',
                                array('formulario' => $formulario->createView()
                                     ,'odi' => $odi
                                     ));
    }
}
