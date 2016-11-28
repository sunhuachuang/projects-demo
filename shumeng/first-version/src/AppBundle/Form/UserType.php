<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('email', 'email')
            ->add('truename')
            ->add('school')
            ->add('area')
            ->add('grade', 'choice', array(
                'choices' => array('2011' => '2011', '2012' => '2012'),
                ))
            ->add('tel', 'integer')
            ->add('password', 'repeated', array(
                'type' => 'password',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\User'
            ));
    }

    public function getName ()
    {
        return 'user_register';
    }
}
