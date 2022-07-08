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
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Veuilez saisir votre non"
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Ici Votre Email"
                ]
            ])
            ->add('sujet', TextType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Ici le sujet de votre message"
                ]
            ])
            ->add('message', TextType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Ici votre message"
                ]
            ])
            ->add('Envoyez', SubmitType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'placeholder' => "Ici votre message"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
