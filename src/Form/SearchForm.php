<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Auteur;
use App\Entity\Livre;
use Couchbase\SearchException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
            "allow_extra_fields" => true
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', SearchType::class, [
                'label' => 'Votre recherche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nom',

            ])
            ->add('auteur', EntityType::class, array(
                'label' => 'auteur',
                'class' => Auteur::class,
                'placeholder' => '',
                'choice_label' => 'nom',
                'required' => false
            ))
            ->add('proprietaire', ChoiceType::class, [
                'choices' => [
                    'Dom' => 'Dom',
                    'Sandra' => 'Sandra',
                    'Jules' => 'Jules',
                    'Nina' => 'Nina'

                ],

                'label' => 'proprietaire du livre',
                'required' => false
            ])
            ->add('dateDebut', IntegerType::class, [
                'label' => 'Année de :',
                'required' => false,

            ])
            ->add('dateFin', IntegerType::class, [
                'label' => 'Année à :',
                'required' => false,

            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Roman' => 'Roman',
                    'BD' => 'BD',
                    'Roman Graphique' => 'Roman Graphique',
                    'essai' => 'Essai'
                ],
                'label' => 'Type de livre',
                'required' => false

            ]);
    }
}
