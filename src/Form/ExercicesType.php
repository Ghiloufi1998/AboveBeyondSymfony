<?php

namespace App\Form;

use App\Entity\Exercices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ExercicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type',ChoiceType::class, [
            'choices'  => [
                'QCM' => 'QCM',
                'Question Réponse' => 'Question Réponse',
                
            ],
        ])
            ->add('question',TextType::class)
            ->add('reponse',TextType::class)
            ->add('hint',TextType::class)
            ->add('image',FileType::class,array('data_class'=>null,'required'=>false))
            ->add('idCrs',null,array('label' => 'Titre du Cours'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
        ]);
    }
}
