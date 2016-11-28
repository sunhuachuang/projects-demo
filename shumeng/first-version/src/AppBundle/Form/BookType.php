<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\BookImageType;
use Doctrine\ORM\EntityRepository;

class BookType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookParentCategory', 'entity', array(
                'class' => 'AppBundle:BookCategory',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('bc')
                        ->where("bc.parent is null");
                    },
                ))
            ->add('bookCategory', 'entity', array(
                'class' => 'AppBundle:BookCategory',
                'choice_label' => 'name',
                ))
            ->add('name', 'text')
            ->add('writer')
            ->add('press')
            ->add('version')
            ->add('shopPrice', 'money', array(
                'currency' => 'CNY',
                ))
            ->add('marketPrice', 'money', array(
                'currency' => 'CNY',
                ))
            ->add('number')
            ->add('oldLevel')
            ->add('brief', 'textarea')
            ->add('coverImg', 'file', array(
                'label' => 'give me cover image',
                ))
            ->add('bookImages', 'collection', array(
                'type' => new BookImageType(),
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Book'
            ));
    }

    public function getName ()
    {
        return 'book';
    }
}
