<?php

namespace cufm\SedaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Odi;
use cufm\SedaBundle\Entity\Objetivo;
use cufm\SedaBundle\Entity\Evaluacion;
use cufm\SedaBundle\Entity\Competencia;
use cufm\SedaBundle\Entity\EvaluacionCompetencia;
use cufm\SedaBundle\Entity\EvaluacionObrero;
use cufm\SedaBundle\Entity\Usuario;
use cufm\SedaBundle\Form\OdiType;
use cufm\SedaBundle\Form\ElegirOdiType;
use cufm\SedaBundle\Form\EditarOdiType;
use cufm\SedaBundle\Form\EvaluacionOdiType;
use cufm\SedaBundle\Form\EvaluacionFormatoType;
use cufm\SedaBundle\Form\CompetenciasType;
use cufm\SedaBundle\Form\EvaluacionType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class OdiController extends Controller
{
    public function indexAction(Request $request)
    {

            $usuario = $this->getUser()->getId();
            //ld($usuario);
            //MUESTRA LOS ODIS DEL USUARIO QUE SE LOGUEA
            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

            $odis = $repositorio->findByUsuario($usuario);
    
        // Leyendo valores de parametros
        $appDir = $this->container->getParameter('kernel.root_dir');
        $configuracion = Yaml::parse($appDir.'/config/parametros.yml');

        $evaluacion = $configuracion['parameters']['evaluacion'];

        // Seteando valor en session
        $session = $request->getSession();
        $session->set('evaluacion', $evaluacion);

        //ld($odis);
              return $this->render('SedaBundle:Odi:index.html.twig',
                                    array('odis' => $odis,
                                          'usuario' => $usuario
                                      ));
    }

    public function mostrarOdiAction($odi_id)
    {
        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');
        $odi = $repositorio->find($odi_id);
        $usuario = $this->getUser()->getId();

        $formulario = $this->createFormBuilder($odi)
            ->add('vbevaluado', 'checkbox', array('label' => 'Estoy de acuerdo con los Objetivos de Desempeño Individual','required'  => false))
            ->getForm();

        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($odi->getVbevaluado() == true) {
                $hoy = new \DateTime('now');
                $odi->setFechaVbevaluado($hoy);
            }
            $em->persist($odi);
            $em->flush();

           return $this->redirect($this->generateUrl('Seda_odis_index'));
        }





        return $this->render('SedaBundle:Odi:mostrarOdi.html.twig',
                                array('odi' => $odi,
                                      'usuario' =>  $usuario,
                                      'formulario' => $formulario->createView()
                                     ));

    }

    public function listaAction()
    {

        $supervisa = $this->getUser()->getSupervisa();


           // $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

           // $consulta = $repositorio->findAll();
            $usuario = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            //MUESTRA LOS ODIS DE LOS SUPERVISADOS DEL USUARIO QUE SE LOGUEA
            $query = $em->createQuery("SELECT o FROM SedaBundle:Odi o INNER JOIN SedaBundle:Usuario u WHERE  o.usuario = u.id AND u.dependencia = :supervisa");
            $query->setParameter('supervisa', $supervisa);
            $odis = $query->getResult();

        //ld($odis);
              return $this->render('SedaBundle:Odi:listaOdi.html.twig',
                                    array('odis' => $odis,
                                          'usuario' =>  $usuario
                                      ));
    }

    public function crearOdiAction()
    {
        $odi = new Odi();


        // creo manualmente los objetivos vacios para el formulario
        $objetivo1 = new Objetivo();
        $objetivo1->name = 'objetivo1';
        $odi->getObjetivos()->add($objetivo1);

        $objetivo2 = new Objetivo();
        $objetivo2->name = 'objetivo2';
        $odi->getObjetivos()->add($objetivo2);

        $objetivo3 = new Objetivo();
        $objetivo3->name = 'objetivo3';
        $odi->getObjetivos()->add($objetivo3);

        $objetivo4 = new Objetivo();
        $objetivo4->name = 'objetivo4';
        $odi->getObjetivos()->add($objetivo4);

        $objetivo5 = new Objetivo();
        $objetivo5->name = 'objetivo5';
        $odi->getObjetivos()->add($objetivo5);


        $supervisa = $this->getUser()->getSupervisa();
		$formulario = $this->createForm(new OdiType($supervisa), $odi);

        $em = $this->getDoctrine()->getManager();
        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        $error = '';

        if ($formulario->isValid()){

            $objetivo4 = $odi->getObjetivos()->get(3)->getObjetivo();
            $objetivo5 = $odi->getObjetivos()->get(4)->getObjetivo();


            // Validando los Objetivos vacioos y eliminandolos
            if (is_null($objetivo4)) {
                $odi->getObjetivos()->remove(3);
                $odi->getObjetivos()->remove(4);
            }elseif (is_null($objetivo5)) {
                $odi->getObjetivos()->remove(4);
            }

        //ld($odi);

            // Validando que no exitan Odis antes de Guardar en Nuevo
            $usuario_id = $odi->getUsuario()->getId();
            $periodo = $odi->getPeriodo();
            $ano = $odi->getAno();

            $repository = $this->getDoctrine()
                ->getRepository('SedaBundle:Odi');

            $query = $repository->createQueryBuilder('o')
                ->where('o.usuario = :usuario AND o.periodo = :periodo AND o.ano = :ano')
                ->setParameters(array('usuario' => $usuario_id,
                                      'periodo' => $periodo,
                                      'ano' => $ano,
                                    ))
                ->getQuery();

            $consulta = $query->getResult();

            if (!$consulta) {
                $creador = $this->getUser();
                $dependencia = $odi->getUsuario()->getDependencia();
                $cargo = $odi->getUsuario()->getCargo();

                $odi->setCreadopor($creador);
                $odi->setDependencia($dependencia);
                $odi->setCargo($cargo);

                //ldd($odi);

                $em->persist($odi);
                $em->flush();

                return $this->redirect($this->generateUrl('Seda_odis_lista'));

            }else{
                $error = 'Ya Exiten O.D.I. Definidos para '.$odi->getUsuario().' en el Semestre '.$periodo.' del año '.$ano;
            }
        }


		return $this->render('SedaBundle:Odi:crearOdi.html.twig',
							array('formulario' => $formulario->createView(),
                                 'odi' => $odi,
                                 'error' => $error
                                 ));

    }

    public function elegirOdiAction()
    {

        $odi = new Odi();
        $supervisa = $this->getUser()->getSupervisa();
        $formulario = $this->createForm(new ElegirOdiType($supervisa), $odi);

        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);
        $error ='';
        if ($formulario->isValid()){
            $data = $formulario->getData();
            $usuario_id = $data->getUsuario()->getId();
            $periodo = $data->getPeriodo();
            $ano = $data->getAno();


            $repository = $this->getDoctrine()
                ->getRepository('SedaBundle:Odi');

            $query = $repository->createQueryBuilder('o')
                ->where('o.usuario = :usuario AND o.periodo = :periodo AND o.ano = :ano')
                ->setParameters(array('usuario' => $usuario_id,
                                      'periodo' => $periodo,
                                      'ano' => $ano,
                                    ))
                ->getQuery();

            $consultaodi = $query->getResult();


            //ldd($consultaodi);
            if (!$consultaodi) {
                $error = 'No Exiten O.D.I. Definidos para '.$data->getUsuario().' en el Semestre '.$periodo.' del año '.$ano;

            }else{
                if (($consultaodi[0]->getVbevaluado() == false) AND ($consultaodi[0]->getVbogth() == false)) {
                    $consultaodi = $consultaodi[0]->getId();
                    return $this->redirect($this->generateUrl('Seda_odis_editar', array('consultaodi' => $consultaodi)));
                }else{
                    $error = 'El O.D.I. del Funcionario '.$data->getUsuario().' en el Semestre '.$periodo.' del año '.$ano. ' No puede ser MODIFICADO mientras este Validado por la O.G.T.H ó por el funcionario';
                }
            }




        }

        return $this->render('SedaBundle:Odi:elegirOdi.html.twig',
                            array('formulario' => $formulario->createView(),
                                  'error' => $error
                                ));
    }

    public function editarOdiAction($consultaodi)
    {

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

        $odi = $repositorio->find($consultaodi);
        //ld($odi);

            // Seteando los objetivos opcionales
             if (count($odi->getObjetivos()->getValues()) == 3) {

                    $objetivo4 = new Objetivo();
                    $objetivo4->name = 'objetivo4';
                    $odi->getObjetivos()->add($objetivo4);

                    $objetivo5 = new Objetivo();
                    $objetivo5->name = 'objetivo5';
                    $odi->getObjetivos()->add($objetivo5);

                }elseif (count($odi->getObjetivos()->getValues()) == 4) {

                    $objetivo5 = new Objetivo();
                    $objetivo5->name = 'objetivo5';
                    $odi->getObjetivos()->add($objetivo5);

                }

            //ld($odi);

            $supervisa = $this->getUser()->getSupervisa();
            $formulario = $this->createForm(new EditarOdiType($supervisa), $odi);


            $peticion = $this->getRequest();
            $formulario->handleRequest($peticion);


            if ($formulario->isValid()){
                //ldd($formulario->getData()->getObjetivos()->get(0));


                $em = $this->getDoctrine()->getManager();

                // Validando los Objetivos vacios y eliminandolos

                $objetivo4 = $odi->getObjetivos()->get(3)->getObjetivo();
                $obj4 = $odi->getObjetivos()->get(3);

                $objetivo5 = $odi->getObjetivos()->get(4)->getObjetivo();
                $obj5 = $odi->getObjetivos()->get(4);

                if (is_null($objetivo4)) {
                    $odi->getObjetivos()->remove(3);
                    $em->remove($obj4);
                }
                if (is_null($objetivo5)) {
                    $odi->getObjetivos()->remove(4);
                    $em->remove($obj5);
                }

                $em->persist($odi);
                $em->flush();

                return $this->redirect($this->generateUrl('Seda_odis_lista'));
            }


            return $this->render('SedaBundle:Odi:editarOdi.html.twig',
                                array('formulario' => $formulario->createView()
                                     ,'odi' => $odi
                                     //,'error' => $error

                                     ));

    }

    public function eliminarListaAction($eliminado)
    {


        $supervisa = $this->getUser()->getSupervisa();
        $em = $this->getDoctrine()->getManager();
        //MUESTRA LOS ODIS DE LOS SUPERVISADOS DEL USUARIO QUE SE LOGUEA
        $query = $em->createQuery("SELECT o FROM SedaBundle:Odi o INNER JOIN SedaBundle:Usuario u WHERE  o.usuario = u.id AND u.dependencia = :supervisa");
        $query->setParameter('supervisa', $supervisa);

        $odis = $query->getResult();

              return $this->render('SedaBundle:Odi:eliminarLista.html.twig',
                                    array('odis' => $odis,
                                            'eliminado' => $eliminado)
                                 );
    }

    public function eliminarOdiAction($odi_id)
    {

        if (!$odi_id)  {
            return $this->redirect($this->generateUrl('Seda_odis_elimina_lista'));
        }

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

        $consulta = $repositorio->find($odi_id);

        if ($consulta->getPeriodo() == 1) {
            $periodo = '1er. Semestre';
        }else{
            $periodo = '2do. Semestre';
        }
        // Validar que el Objetivo no tenga el Vb de OGTH y del Funcionario
        if ($consulta->getVbevaluado() == false and $consulta->getVbogth() == false) {
           $eliminado = 'Se Elimino el O.D.I del funcionario '.$consulta->getUsuario().' del periodo '.$periodo.' del año '.$consulta->getAno();
           $em = $this->getDoctrine()->getManager();
           $em->remove($consulta);
           $em->flush();
        } else {
            $eliminado = 'No se puede eliminar el O.D.I del funcionario '.$consulta->getUsuario().' del periodo '.$periodo.' del año '.$consulta->getAno(). ' por que esta Validado por O.G.T.H. ó por el Funcionario';
        }


    return $this->redirect($this->generateUrl('Seda_odis_elimina_lista', array('eliminado' => $eliminado)));

    }

    public function imprimirListaAction()
    {

        $supervisa = $this->getUser()->getSupervisa();
        $em = $this->getDoctrine()->getManager();
        //MUESTRA LOS ODIS DE LOS SUPERVISADOS DEL USUARIO QUE SE LOGUEA
        $query = $em->createQuery("SELECT o FROM SedaBundle:Odi o INNER JOIN SedaBundle:Usuario u WHERE  o.usuario = u.id AND u.dependencia = :supervisa");
        $query->setParameter('supervisa', $supervisa);

        $odis = $query->getResult();

              return $this->render('SedaBundle:Odi:imprimirLista.html.twig',
                                    array('odis' => $odis)
                                 );
    }

    public function pdfOdiAction($odi_id)
        {

            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

            $odis = $repositorio->findById($odi_id);

            //ldd($odis);
    /*
                  return $this->render('SedaBundle:Odi:pdf.html.twig',
                                        array('odis' => $odis)
                                     );

    */
            $html = $this->renderView('SedaBundle:Odi:pdf.html.twig', array(
                'odis'  => $odis
            ));


            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                                       array('orientation'=>'Landscape',
                                             'default-header'=>false)),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="file.pdf"'
                )
            );

        }

    public function evaluacionListarAction($eliminado)
    {

            //$eliminado ='';
            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Evaluacion');

            $evaluaciones = $repositorio->findAll();

        return $this->render('SedaBundle:Odi:evaluacionListar.html.twig',
                             array('evaluaciones' => $evaluaciones,
                                   'eliminado' => $eliminado
                                ));
    }


    public function evaluacionEliminarAction($evaluacion_id)
    {

        if (!$evaluacion_id)  {
            return $this->redirect($this->generateUrl('Seda_evaluacion_listar'));
        }

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Evaluacion');

        $repocomp = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionCompetencia');

        $repoobj = $this->getDoctrine()->getRepository('SedaBundle:Objetivo');

        $consulta = $repositorio->find($evaluacion_id);

        $id = $consulta->getOdi();

        $competencias = $repocomp->findByOdi($id);

        $objetivos = $repoobj->findByOdi($id);





        //ld($competencias);
        //ld($objetivos->count());

        for ($i=0; $i < count($objetivos) ; $i++) {
            $objetivos[$i]->setFechaEvaluacion(null);
            $objetivos[$i]->setRango(null);
            $objetivos[$i]->setPesoxrango(null);
        }
/*
        ld($consulta->getOdi()->getObjetivos()->get(0)->getFechaEvaluacion());
        ld($consulta->getOdi()->getObjetivos()->get(0)->getRango());
        ld($consulta->getOdi()->getObjetivos()->get(0)->getPesoxrango());

        ldd($consulta);


        ld($competencias);
        ld($objetivos[0]);
*/

        if ($consulta->getOdi()->getPeriodo() == 1) {
            $periodo = '1er. Semestre';
        }else{
            $periodo = '2do. Semestre';
        }
        //ldd($consulta->getOdi()->getUsuario());

        $eliminado = 'Se Elimino La Evaluacion del funcionario '.$consulta->getOdi()->getUsuario().' del periodo '.$periodo.' del año '.$consulta->getOdi()->getAno();


           $em = $this->getDoctrine()->getManager();
                for ($i=0; $i < count($objetivos) ; $i++) {
                    $em->persist($objetivos[$i]);
                }
                for ($i=0; $i < count($competencias) ; $i++) {
                    $em->remove($competencias[$i]);
                }

            $em->remove($consulta);
           //$em->remove($competencias);
           //$em->persist($objetivos);
           //ldd($em);
           $em->flush();



    return $this->redirect($this->generateUrl('Seda_evaluacion_listar', array('eliminado' => $eliminado)));
    //return $this->redirect($this->generateUrl('Seda_odis_elimina_lista', array('eliminado' => $eliminado)));
    }


    public function evaluacionOdiAction($odi_id)
    {


        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');
        $odi = $repositorio->find($odi_id);

        //ld($odi);

        $nivel = $odi->getUsuario()->getNivel();
        $repositorio1 = $this->getDoctrine()->getRepository('SedaBundle:Competencia');
        $competes = $repositorio1->findByTipo($nivel);

        $competencia = new Competencia();

        for ($i=0; $i < count($competes); $i++) {
            $evalComp = new EvaluacionCompetencia();
            $evalComp->name = 'competencia'+$i;
            $competencia->getCompetencias()->add($evalComp);
        }

        //ld($Competencia);

        $evaluacion = new Evaluacion();


        $data = array('odi' => $odi, 'competencia' => $competencia, 'evaluacion' => $evaluacion);

        $form = $this->createFormBuilder($data)
            ->add('odi', new EvaluacionOdiType(), array(
                'data_class' => 'cufm\SedaBundle\Entity\Odi', // Where we store our entities
            ))
            ->add('competencia',new CompetenciasType(), array(
                'data_class' => 'cufm\SedaBundle\Entity\Competencia', // Where we store our entities
            ))
            ->add('evaluacion', new EvaluacionType(), array(
                'data_class' => 'cufm\SedaBundle\Entity\Evaluacion', // Where we store our entities
            ))

            ->getForm();


        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {

        $em = $this->getDoctrine()->getManager();

            for ($i=0; $i < count($competes); $i++) {
                $form->get('competencia')->getData()->getCompetencias()->get($i)->setCompetencia($competes[$i]);
                $form->get('competencia')->getData()->getCompetencias()->get($i)->setOdi($form->get('odi')->getData());

                $evalcompete = $form->get('competencia')->getData()->getCompetencias()->get($i);
                $em->persist($evalcompete);

            };

            //ldd($form->get('competencia')->getData()->getCompetencias()->get(0));

            $evalodi = $form->get('odi')->getData();
            $em->persist($evalodi);


            $form->get('evaluacion')->getData()->setOdi($form->get('odi')->getData());
            $evaleval = $form->get('evaluacion')->getData();
            $em->persist($evaleval);

            $em->flush();


            //$session = $this->getRequest()->getSession();
            //$session->getFlashBag()->add('message', gettext('Saved!'));

            if (($form->get('evaluacion')->getData()->getTotal() >= 420 ) AND ($form->get('evaluacion')->getData()->getTotal() <= 500 )) {
                $repositorio2 = $this->getDoctrine()->getRepository('SedaBundle:Evaluacion');
                $eval = $repositorio2->findByOdi($odi_id);
                $eval_id = $eval[0]->getId();

                //ldd($eval_id);

            return $this->redirect($this->generateUrl('Seda_evaluacion_formato', array('eval_id' => $eval_id)));

            } else {
                return $this->redirect($this->generateUrl('Seda_odis_lista'));
            };




        }

        return $this->render('SedaBundle:Odi:evaluacionOdi.html.twig', array('form' => $form->createView()
                                                                    ,'odi' => $odi
                                                                    ,'competes' => $competes));

    }

    public function evaluacionFormatoAction($eval_id)
    {

        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Evaluacion');
        $eval = $repositorio->findById($eval_id);
        //ldd($eval[0]->getOdi()->getId());
        $formato = $eval[0];
        $repo = $this->getDoctrine()->getRepository('SedaBundle:Odi');
        $odi = $repo->findById($eval[0]->getOdi()->getId());


        $formulario = $this->createForm(new EvaluacionFormatoType(), $formato);


        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);


        if ($formulario->isValid()){

            //$evaluacion = $formulario->getData();
            //ld($eval[0]);

            //ldd($formato);
            $em = $this->getDoctrine()->getManager();

            $em->persist($formato);

            $em->flush();
            return $this->redirect($this->generateUrl('Seda_odis_lista'));
        };





        return $this->render('SedaBundle:Odi:evaluacionFormato.html.twig', array('formulario' => $formulario->createView()
                                                                    ,'formato' => $formato
                                                                    ,'odi' => $odi[0]
                                                                    ));

    }

    public function evaluacionMostrarAction($odi_id)
    {
        $usuario = $this->getUser()->getId();
        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');
        $odi = $repositorio->find($odi_id);
        $evaluacion = $odi->getEvaluacion()->get(0);
        //ldd($evaluacion);
        $hoy =new \DateTime('now');

        $formulario = $this->createFormBuilder($evaluacion)
            ->add('fechaevaluado', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'required'=>false, 'data' => $hoy))
            ->add('aprobacionevaluado', 'choice', array('choices' => array('1' => 'Si',
                                                                           '0' => 'No'),
                                                        'expanded' => true,
                                                        'multiple' => false ))
            ->add('comentariosupervisado', 'textarea', array('required'=>false))
            ->getForm();

        $peticion = $this->getRequest();
        $formulario->handleRequest($peticion);

        if ($formulario->isValid()) {
            //ldd($evaluacion);
            $em = $this->getDoctrine()->getManager();

            $em->persist($evaluacion);
            $em->flush();

           return $this->redirect($this->generateUrl('Seda_odis_index'));
        }

        return $this->render('SedaBundle:Odi:evaluacionMostrar.html.twig', array('formulario' => $formulario->createView(),
                                                                                 'odi' => $odi,
                                                                                 'usuario' => $usuario,
                                                                                 'evaluacion' => $evaluacion));
    }

    public function pdfEvaluacionAction($odi_id)
        {

            $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Odi');

            $odi = $repositorio->find($odi_id);

            // dependencia de evaluado
            $dependencia = $odi->getUsuario()->getDependencia()->getId();

            $repodep = $this->getDoctrine()->getRepository('SedaBundle:Usuario');

            $supervisor = $repodep->findBySupervisa($dependencia);

            // supervisor del evaluado

            $super =$supervisor[0];

            // dependencia de supervisor del evaluado
            $depenmedia = $super->getDependencia()->getId();

            $repomediato = $this->getDoctrine()->getRepository('SedaBundle:Usuario');

            $supermediato = $repomediato->findBySupervisa($depenmedia);

            // supervisor mediato del evaluado
            $mediato = $supermediato[0];

            //ld($odi->getUsuario()->getDependencia()->getId());
            //ld($super);
            //ldd($mediato);
      /*
                  return $this->render('SedaBundle:Odi:pdfEvaluacion.html.twig',
                                        array('odi' => $odi,
                                            'super' => $super,
                                            'mediato' => $mediato,
                                            )
                                     );
        */

            $html = $this->renderView('SedaBundle:Odi:pdfEvaluacion.html.twig', array('odi'  => $odi,
                                                                                    'super' => $super,
                                                                                    'mediato' => $mediato
             ));


            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                                       array('page-size' => 'Letter',
                                             'orientation'=>'Landscape',
                                             'default-header'=>false)),
                                              200,
                                       array(
                                            'Content-Type'          => 'application/pdf',
                                            'Content-Disposition'   => 'attachment; filename="file.pdf"'
                                            )
                                            );

        }

        public function opcionesListadoEvaluacionAction()
        {

            $formulario = $this->createFormBuilder()
                ->add('tipo','choice', array('choices' => array('1' =>'Administrativos',
                                                                '2' =>'Obreros'),
                                                'data'=>'1',
                                                'expanded' => true,
                                                'multiple' => false) )              
                ->add('periodo','choice', array('choices' => array('1' =>'1er. Semestre',
                                                                   '2' =>'2do. Semestre'),
                                                'data'=>'1',
                                                'expanded' => true,
                                                'multiple' => false) )         
                ->add('ano','choice', array('choices' => array( '2015' =>'2015',
                                                                '2016' =>'2016',
                                                                '2017' =>'2017',
                                                                '2018' =>'2018',
                                                                '2019' =>'2019',
                                                                '2020' =>'2020'),
                                            'empty_value' => 'Seleccione...' ) ) 
                ->add('orden','choice', array('choices' => array('ASC' =>'Ascendente',
                                                                 'DESC' =>'Descendente'),
                                                'data'=>'ASC',
                                                'expanded' => true,
                                                'multiple' => false) )              
                ->getForm();

            $peticion = $this->getRequest();
            $formulario->handleRequest($peticion);

            if ($formulario->isValid()) {
                
                $datos = $formulario->getData();
                $periodo = $datos['periodo'];
                $ano = $datos['ano'];
                $orden = $datos['orden'];
                $tipo = $datos['tipo'];

                $response = $this->forward('SedaBundle:Odi:pdfEvaluacionl', array(
                    'orden' => $orden,
                    'periodo' => $periodo,
                    'ano' => $ano, 
                    'tipo' => $tipo
                ));
             
                             
                return $response;                

            }

            return $this->render('SedaBundle:Odi:opcionesListadoEvaluacion.html.twig',
                                    array('formulario' => $formulario->createView()
                                         ));

        }

        public function pdfEvaluacionlAction($orden, $periodo, $ano, $tipo)
        {
            //ld($tipo);
            
            if ($tipo == 1) {
                $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Evaluacion');

               // $evaluaciones = $repositorio->findBy( array('fecha' => '>20'), array('total' => 'ASC'));

               $query = $repositorio->createQueryBuilder('e')
                    ->innerJoin('e.odi','o')
                    ->where('o.periodo = :periodo')
                    ->andwhere('o.ano = :ano')
                    ->orderBy('e.total', $orden)
                    ->setParameters(array(
                                        'ano' => $ano,
                                        'periodo' => $periodo
                                        ))
                    ->getQuery();

                $evaluaciones = $query->getResult();
                $personal = 'Administrativos';
                $html = $this->renderView('SedaBundle:Odi:pdfEvaluacionl.html.twig', array('evaluaciones'  => $evaluaciones,
                                                                                            'periodo' => $periodo,
                                                                                            'ano' => $ano));                
            }

            if ($tipo == 2) {
                $repositorio = $this->getDoctrine()->getRepository('SedaBundle:EvaluacionObrero');

               // $evaluaciones = $repositorio->findBy( array('fecha' => '>20'), array('total' => 'ASC'));

               $query = $repositorio->createQueryBuilder('e')
                    ->where('e.periodo = :periodo')
                    ->andwhere('e.ano = :ano')
                    ->orderBy('e.total', $orden)
                    ->setParameters(array(
                                        'ano' => $ano,
                                        'periodo' => $periodo
                                        ))
                    ->getQuery();

                $evaluaciones = $query->getResult();
                $personal = 'Obreros';
            $html = $this->renderView('SedaBundle:EvaluacionObrero:report.html.twig', array('evaluaciones'  => $evaluaciones,
                                                                                            'periodo' => $periodo,
                                                                                            'ano' => $ano));                
            }            

            //$evaluaciones = $repositorio->findAll();
/*            
                  return $this->render('SedaBundle:Odi:pdfEvaluacionl.html.twig',
                                        array('evaluaciones' => $evaluaciones,
                                             // 'odis' => $odis,
                                            )
                                     );
*/            
            //ldd($evaluaciones);

            //$html = $this->renderView('SedaBundle:Odi:pdfEvaluacionl.html.twig', array('evaluaciones'  => $evaluaciones));


            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
                                       array('page-size' => 'Letter',
                                             'orientation'=>'Landscape',
                                             'default-header'=>false)),
                                              200,
                                       array(
                                            'Content-Type'          => 'application/pdf',
                                            'Content-Disposition'   => 'attachment; filename="Evaluaciones-'.$personal.'-'.$periodo.'-'.$ano.'.pdf"'
                                            )
                                            );

        }



}
