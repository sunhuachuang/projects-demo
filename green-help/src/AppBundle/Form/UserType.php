<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parentName')
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => array('label' => ' 一级密码'),
                'second_options' => array('label' => '确认密码'),
            ])
            ->add('secondPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => array('label' => '二级密码'),
                'second_options' => array('label' => '确认密码'),
            ])
            ->add('bankObject', EntityType::class, array(
                'class' => 'AppBundle:Param',
                'choice_label' => 'value',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.type = :type')
                        ->setParameter('type', 'banks');
                    }
            ))
            ->add('bankNumber')
            ->add('bankName')
            ->add('bankProvince')
            ->add('bankCity')
            ->add('bankAddress')
            ->add('reportDepartment')
            ->add('referencePhone')
            ->add('phone')
            ->add('myPay')
            ->add('cartId')
            ->add('agreeFlag')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}
