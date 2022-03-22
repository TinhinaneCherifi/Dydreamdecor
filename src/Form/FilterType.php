<?php

namespace App\Form;

use App\Service\Filter;
use App\Entity\ItemCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemString', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherchez ...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('itemCategories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => ItemCategory::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'filtrer',
                'attr' => [
                    'class' => 'btn-block btn-secondary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class, 
            'method' =>'GET',
            'csrf_protection' => false, 
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}