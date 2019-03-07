<?php

namespace cufm\SedaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cufm\SedaBundle\Entity\Objetivo;

class ObjetivoController extends Controller
{
    public function indexAction()
    {
        $repositorio = $this->getDoctrine()->getRepository('SedaBundle:Objetivo');

        $objetivos = $repositorio->findAll();

        return $this->render('SedaBundle:Objetivo:index.html.twig',
                                    array('objetivos' => $objetivos,
                                          'encabezado' => 'Lista de Objetivos'
                                        )
                            );
    }
}