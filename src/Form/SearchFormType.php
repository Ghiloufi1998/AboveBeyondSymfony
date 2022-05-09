<?php

namespace App\Form;

use App\Entity\SearchData;
use App\Entity\Sondage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SearchBar')
            ->add('sondage',EntityType::class,[
                'required'=>false,
                  'class'=>Sondage::class,
                  'choice_label' => 'categorie',
                  'expanded'=>true,
                  'multiple'=>true,
                  'mapped'  => false,

            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
           /* 'methode'=>'GET',
            'csrf_protection'=>false*/
        ]);
    }

  public function getBlockPrefix(){
        return '';
    }
}
