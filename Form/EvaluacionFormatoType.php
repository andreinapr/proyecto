<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Entity\Evaluacion;


class EvaluacionFormatoType extends AbstractType
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


            
            ->add('logroadicional', 'textarea',array('required'=>false))
            ->add('impacto', 'textarea',array('required'=>false))
            ->add('competenciasindividual', 'textarea',array('required'=>false))

            
            

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
        return 'evaluacionformato';
    }
}
