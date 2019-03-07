<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Entity\Evaluacion;


class EvaluacionType extends AbstractType
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


            ->add('totalobjetivos', 'text',array('required'=>false))
            ->add('totalcompetencias', 'text',array('required'=>false))
            ->add('total', 'text',array('required'=>false))
            ->add('fecha', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'required'=>false, 'data' => $this->hoy))
            ->add('comentariosupervisor', 'textarea',array('required'=>false))

            
            /*
            ->add('id','hidden', array('mapped' => false ))
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
            'data_class' => 'cufm\SedaBundle\Entity\Evaluacion',	
            'cascade_validation' => true, 
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'evaluacion';
    }
}
