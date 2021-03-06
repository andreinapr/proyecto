<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ObjetivoType extends AbstractType
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
		
            ->add('objetivo', 'textarea', array('required'=>false))
			->add('peso','choice', array('choices' => array('5' =>'5',
                                                            '10' =>'10',
                                                            '15' =>'15',
                                                            '20' =>'20',
                                                            '25' =>'25'),
                                        'empty_value' => 'Seleccione...', 'required'=>false))
			->add('primera_revision', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'empty_value' => '', 'required'=>false))
			->add('segunda_revision', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'empty_value' => '', 'required'=>false))    
			->add('tercera_revision', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'empty_value' => '', 'required'=>false))
            ->add('fecha_creacion', 'date', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy', 'required'=>false, 'data' => $this->hoy))
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
        return 'objetivo';
    }
}
