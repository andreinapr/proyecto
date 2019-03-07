<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DependenciaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denominacion', 'text', array('required'=>true))
            ->add('iniciales', 'text', array('required'=>false))
            ->add('codigo', 'text', array('required'=>false))
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
            'data_class' => 'cufm\SedaBundle\Entity\Dependencia'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dependencia';
    }
}
