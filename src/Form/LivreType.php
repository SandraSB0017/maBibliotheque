<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('auteur', AuteurType::class, [
                'label' => 'Auteur',
//                'class'=> Auteur::class,
//                'choice_label'=>'nom'
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé'
            ])
            ->add('annee', IntegerType::class, [



                'label' => 'Année de sortie'
        ])


            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Roman' => 'Roman',
                    'BD' => 'BD',
                    'Roman Graphique' => 'Roman Graphique',
                    'essai' => 'Essai'
                ],
                'multiple' => false
            ])
            ->add('proprietaire', ChoiceType::class, [
                'choices' => [
                    'Dom' => 'Dom',
                    'Sandra' => 'Sandra',
                    'Jules' => 'Jules',
                    'Nina' => 'Nina'

                ]
            ])
            ->add('photo', FileType::class, [
                'label' => 'Couverture (jpeg fille)',
                'multiple' => false,
                'mapped' => false,
                'required' => false


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
