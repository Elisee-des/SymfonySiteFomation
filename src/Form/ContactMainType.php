<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr"=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                "attr"=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('sujet', TextType::class, [
                "attr"=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('message', TextType::class, [
                "attr"=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('Envoyez', SubmitType::class, [
                "attr"=>[
                    'class'=>'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
