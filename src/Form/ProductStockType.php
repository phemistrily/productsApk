<?php

namespace App\Form;

use App\Entity\ProductStock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;
use App\Entity\ProductOwner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expiration_date')
            ->add('quantity')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
            ])
            ->add('product_owner', EntityType::class, [
                'class' => ProductOwner::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductStock::class,
        ]);
    }
}
