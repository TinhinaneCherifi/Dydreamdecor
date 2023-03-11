<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom du lieu', 
                'attr' =>[
                    'placeholder' => 'Ex. Maison, Bureau, ...'
                ]
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom', 
                'attr' =>[
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom', 
                'attr' =>[
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('company', TextType::class,[
                'label' => 'Nom de votre entreprise (facultatif)', 
                'attr' =>[
                    'placeholder' => 'Nom de votre entreprise'
                ],
                'required' => false
            ])
            ->add('address', TextType::class,[
                'label' => 'Adresse', 
                'attr' =>[
                    'placeholder' => 'Votre adresse'
                ]
            ])
            ->add('zip', TextType::class,[
                'label' => 'Code postal', 
                'attr' =>[
                    'placeholder' => 'Votre code postal'
                ]
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville', 
                'attr' =>[
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('country', CountryType::class,[
                'label' => 'Pays', 
                'attr' =>[
                    'placeholder' => 'Votre pays',
                    'class' => 'custom-select'
                ]
            ])
            ->add('phone', TelType::class,[
                'label' => 'Numéro de téléphone', 
                'attr' =>[
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider l\'adresse', 
                'attr' =>[
                    'class' => 'col-md-2 offset-md-10 btn-block btn-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
