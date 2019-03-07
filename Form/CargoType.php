<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CargoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denominacion', 'text', array('required'=>true))
            ->add('activo', 'choice', array('choices' => array('1' => 'Si',
                                                               '0' => 'No'),
                                                'expanded' => true,
                                                'multiple' => false ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\Cargo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cargo';
    }
}
