<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ObjetivoEvaluacionType extends AbstractType
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

            ->add('peso', 'text',array('required'=>false))
			->add('rango','choice', array('choices' => array('1' =>'1',
                                                             '2' =>'2',
                                                             '3' =>'3',
                                                             '4' =>'4',
                                                             '5' =>'5'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('pesoxrango', 'text',array('required'=>false))
            
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
            'data_class' => 'cufm\SedaBundle\Entity\Objetivo',	
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'objetivoevaluacion';
    }
}
