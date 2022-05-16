<?php

namespace App\Form;

use App\Entity\Voyageorganise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VoyageorganiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('image',FileType::class,['label'=> 'Image : '] )
            ->add('prix')
            ->add('nbrePlaces')
            ->add('vol')
            ->add('transport')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voyageorganise::class,
        ]);
    }
}
