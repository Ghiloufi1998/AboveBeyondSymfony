<?php

namespace App\Form;

use App\Entity\Guide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Intl\Countries;


class GuideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class)
            ->add('pays', CountryType::class)
            ->add('level',TextType::class)
            ->add('image',FileType::class,array('data_class'=>null,'required'=>false))
            ->add('idVol',null,array('label' => 'Destination de Vol'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guide::class,
        ]);
    }
}
