<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use cufm\SedaBundle\Entity\Usuario; 
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Form\ObjetivoType;
use cufm\SedaBundle\Form\ObjetivoRevisionType;
use cufm\SedaBundle\Entity\Objetivo;

class RevisionOdiType extends AbstractType
{

    public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    	$builder

            /*
            ->add('total_pesos', 'text',array('mapped'=>false, 'required'=>false))
            
            ->add('usuario', 'entity', array('class' => 'cufm\\SedaBundle\\Entity\\Usuario',
                                        //'class' => 'SedaBundle:Usuario',
                                        //'query_builder' => function(EntityRepository $er) {
                                        //    return $er->createQueryBuilder('u')
                                        //        ->where('u.dependencia = :supervisa')
                                        //        ->setParameter('supervisa', $this->supervisa);},
                                        'expanded' => false,
                                        'empty_value' => 'Seleccione...'))
            ->add('periodo','choice', array('choices' => array('1' =>'1er. Semestre',
                                                               '2' =>'2do. Semestre'),
                                            'expanded' => true,
                                            'multiple' => false) )  
            ->add('ano','choice', array('choices' => array('2014' =>'2014',
                                                            '2015' =>'2015',
                                                            '2016' =>'2016',
                                                            '2017' =>'2017',
                                                            '2018' =>'2018',
                                                            '2019' =>'2019',
                                                            '2020' =>'2020'),
                                        'empty_value' => 'Seleccione...' ) )                
            */
            ->add('vbogth', 'checkbox', array('label' => 'ODI Validado','required'  => false))
            
            ->add('objetivos', 'collection', array(
                'type'           => new ObjetivoRevisionType(),
                'label'          => 'Objetivos',
                'by_reference'   => false,
                'allow_delete'   => true,
                'allow_add'      => true              
            ))


        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\Odi',
        'cascade_validation' => true,   
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'odirevision';
    }
}