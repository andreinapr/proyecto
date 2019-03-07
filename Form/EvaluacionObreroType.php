<?php

namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use cufm\SedaBundle\Entity\Usuario; 
use Doctrine\ORM\EntityRepository;

class EvaluacionObreroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function __construct($supervisa)
    {
        $this->supervisa = $supervisa;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evaluado', 'entity', array(
                                        //'class' => 'cufm\\SedBundle\\Entity\\Usuario',
                                        'class' => 'SedaBundle:Usuario',
                                        'query_builder' => function(EntityRepository $er) {
                                            return $er->createQueryBuilder('u')
                                                ->orderBy('u.apellidos', 'ASC')
                                                ->where('u.dependencia = :supervisa')
                                                ->andWhere('u.tipoPersonal = 3')
                                                ->andWhere('u.isActive = 1')
                                                ->setParameter('supervisa', $this->supervisa);},
                                        'expanded' => false,
                                        'empty_value' => 'Seleccione...'))
            ->add('periodo','choice', array('choices' => array('1' =>'1er. Semestre',
                                                               '2' =>'2do. Semestre'),
                                            'expanded' => true,
                                            'multiple' => false)) 
            ->add('ano','choice', array('choices' => array(
                                                            '2016' =>'2016',
                                                            '2017' =>'2017',
                                                            '2018' =>'2018',
                                                            '2019' =>'2019',
                                                            '2020' =>'2020'),
                                        'empty_value' => 'Seleccione...' )) 
            ->add('factoresEvaluacion1','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion2','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion3','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion4','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion5','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion6','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion7','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresEvaluacion8','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false))
            ->add('factoresSupervision1','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false,
                                            'required'=>false))
            ->add('factoresSupervision2','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false,
                                            'required'=>false))
            ->add('factoresSupervision3','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false,
                                            'required'=>false))
            ->add('factoresSupervision4','choice', array('choices' => array('5' =>'5',
                                                             '4' =>'4',
                                                             '3' =>'3',
                                                             '2' =>'2',
                                                             '1' =>'1'),
                                            'expanded' => true,
                                            'multiple' => false,
                                            'required'=>false))
            ->add('comentarioDesempeno', 'textarea', array('required'=>false))
            ->add('aspectosMejorar', 'textarea', array('required'=>false))
            ->add('aspectosSignificativos', 'textarea', array('required'=>false))
            ->add('totalExcelente', 'text',array('mapped'=>false, 'required'=>false))
            ->add('totalMuybueno', 'text',array('mapped'=>false, 'required'=>false))
            ->add('totalBueno', 'text',array('mapped'=>false, 'required'=>false))
            ->add('totalRegular', 'text',array('mapped'=>false, 'required'=>false))
            ->add('totalDeficiente', 'text',array('mapped'=>false, 'required'=>false))

            ->add('total', 'hidden',array('required'=>false))
            

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\EvaluacionObrero'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'evaluacionobrero';
    }
}
