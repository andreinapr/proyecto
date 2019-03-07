<?php
namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use cufm\SedaBundle\Entity\Usuario; 
use Doctrine\ORM\EntityRepository;

class ElegirEvaluacionObreroType extends AbstractType
{

    public function __construct($supervisa)
    {
        $this->supervisa = $supervisa;

    }

    /**
     * {@inheritdoc}
     */
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
                                            'multiple' => false) )  
            ->add('ano','choice', array('choices' => array('2016' =>'2016',
                                                            '2017' =>'2017',
                                                            '2018' =>'2018',
                                                            '2019' =>'2019',
                                                            '2020' =>'2020'),
                                        'empty_value' => 'Seleccione...' ) )                
		;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\EvaluacionObrero',	
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'elegirevaluacion';
    }
}
