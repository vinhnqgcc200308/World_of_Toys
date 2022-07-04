<?php

namespace App\Form;

use App\Entity\Orderdetail;
use Symfony\Component\Form\AbstractType;
use App\Form\EventListener\RemoveCartItemListener;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('remove', SubmitType::class);
            $builder->addEventSubscriber(new RemoveCartItemListener());
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orderdetail::class
        ]);
    }
}