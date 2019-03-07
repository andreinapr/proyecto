<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Entity\EvaluacionCompetencia;


class EvalCompetenciaType extends AbstractType
{
    public function __construct()
    {
        $this->hoy = new \DateTime('now');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    	$builder

            ->add('peso', 'choice',array('choices' => array('1' =>'1',
                                                          '2' =>'2',
                                                          '3' =>'3',
                                                          '4' =>'4',
                                                          '5' =>'5',
                                                          '6' =>'6',                                                          
                                                          '7' =>'7',
                                                          '8' =>'8')))
			->add('rango','choice', array('choices' => array('1' =>'1',
                                                             '2' =>'2',
                                                             '3' =>'3',
                                                             '4' =>'4',
                                                             '5' =>'5'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('pesoxrango', 'text',array('required'=>false))
            /*->add('competencia', 'entity', array('class' => 'cufm\\SedaBundle\\Entity\\Competencia',
                                                 'expanded' => false,
                                                 'empty_value' => 'Seleccione...'))
            */
            
            /*
            ->add('observaciones', 'entity', array('class' => 'cufm\\SedaBundle\\Entity\\Observacion',
                                                'expanded' => true,
                                                'multiple' => true))
            */

		;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\EvaluacionCompetencia',	
            'cascade_validation' => true, 
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'evalcompetencia';
    }
}
