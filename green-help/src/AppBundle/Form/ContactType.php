<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices'  => [
                    '匹配问题' => '匹配问题',
                    '对方不打款' => '对方不打款',
                    '恶意确认' => '恶意确认',
                    '订单超时' => '订单超时',
                    '个人账号' => '个人账号',
                    '提供建议' => '提供建议',
                ],
            ])
            ->add('selfUsername')
            ->add('username')
            ->add('phone')
            ->add('message')
            ->add('isCompany')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }
}
