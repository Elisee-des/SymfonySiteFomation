<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CandidaturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user', EntityType::class, [
            "class"=> User::class,
            "attr"=>[
                "label"=>"Choisir l'utilisateur"
            ]
        ])
        ->add('formation')
        ->add('niveauEtude', TextType::class, [
            "attr"=>[
                "label"=>" Niveau d'etude"
            ]
        ])
            ->add('fichiers', FileType::class, [
                "mapped"=>false,
                "constraints"=>[
                    new File([
                        "maxSize"=>"2M",
                        "mimeTypes"=>[
                            "image/jpeg",
                            "image/png"
                        ]
                    ])
                ]
            ])

            ->add('Confirmer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
