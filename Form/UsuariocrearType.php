<?php
namespace cufm\SedaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use cufm\SedaBundle\Entity\Usuario; 
use cufm\SedaBundle\Entity\Dependencia; 
use cufm\SedaBundle\Entity\Cargo; 

	
class UsuarioCrearType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
			->add('nombres', 'text')
            ->add('apellidos', 'text')
            ->add('cedula', 'text')
            ->add('cargo', 'entity', array(
                                            //'class' => 'cufm\\SedaBundle\\Entity\\Cargo',
                                            'class' => 'SedaBundle:Cargo',
                                            'query_builder' => function(EntityRepository $er) {
                                                return $er->createQueryBuilder('c')
                                                    ->orderBy('c.denominacion', 'ASC')
                                                    ->where('c.activo = 1');},                                             
                                            'expanded' => false,
                                            'empty_value' => 'Seleccione...'))
            ->add('nivel', 'choice', array('choices' => array('1' => 'Bachiller',
                                                              '2' => 'Técnico',
                                                              '3' => 'Supervisorio'),
                                            'expanded' => true,
                                            'multiple' => false ))                                                        
            ->add('dependencia', 'entity', array(
                                            //'class' => 'cufm\\SedaBundle\\Entity\\Dependencia',
                                                'class' => 'SedaBundle:Dependencia',
                                                'query_builder' => function(EntityRepository $er) {
                                                    return $er->createQueryBuilder('d')
                                                        ->orderBy('d.denominacion', 'ASC')
                                                        ->where('d.activo = 1');},                                            
                                                    'expanded' => false,
                                                    'empty_value' => 'Seleccione...'))
            ->add('tipoPersonal', 'choice', array('choices' => array('1' => 'Administrativo',
                                                                     '2' => 'Docente',
                                                                     '3' => 'Obrero'),
                                                                   'expanded' => true,
                                                                   'multiple' => false ))
            ->add('supervisor', 'choice', array('choices' => array('1' => 'Si',
                                                                   '0' => 'No'),
                                                                   'expanded' => true,
                                                                   'multiple' => false ))  
            ->add('supervisa', 'entity', array(
                                            'class' => 'cufm\\SedaBundle\\Entity\\Dependencia',
                                            'expanded' => false,
                                            'empty_value' => 'Seleccione...'))                                                                                 

            ->add('username', 'email')
			->add('password', 'password', array('always_empty' => false))
			->add('isActive', 'choice', array('choices' => array('1' => 'Si',
    															 '0' => 'No'),
												'expanded' => true,
												'multiple' => false ))
			->add('roles', 'entity', array(
    										'class' => 'cufm\\SedaBundle\\Entity\\Role',
    										'expanded' => true,
    										'multiple' => true))
		;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cufm\SedaBundle\Entity\Usuario',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Usuariocrear';
    }
}
