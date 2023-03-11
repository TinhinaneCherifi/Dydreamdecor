<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('email', EmailType::class,[
                'label' => 'Adresse email', 
                'attr' =>[
                    'placeholder' => 'Votre adresse email'
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Message', 
                'attr' =>[
                    'placeholder' => 'Rédigez un message ...'
                ],
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer', 
                'attr' =>[
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
