<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('type',ChoiceType::class, [
            'choices'  => [
                'Vidéo' => 'Vidéo',
                'Texte' => 'Texte',
                
            ],
        ])
            ->add('titre',TextType::class)
            ->add('contenu',TextType::class)
            ->add('image',FileType::class,array('data_class'=>null,'required'=>false))
            ->add('idG',null,array('label' => 'Titre du guide'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
