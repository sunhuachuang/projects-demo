<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookOrderType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('zipcode', 'integer')
            ->add('reciver')
            ->add('tel', 'integer')
            ->add('email', 'email')
            ->add('orderDesc');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\BookOrder'
            ));
    }

    public function getName ()
    {
        return 'book_order';
    }
}
