<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use cufm\SedaBundle\Entity\Usuario; 
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Form\ObjetivoEvaluacionType;
use cufm\SedaBundle\Entity\Objetivo;

class EvaluacionOdiType extends AbstractType
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

            ->add('totalevaluacion', 'text',array('mapped'=>false, 'required'=>false))
            ->add('objetivos', 'collection', array(
                'type'           => new ObjetivoEvaluacionType(),
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
        return 'odievaluacion';
    }
}