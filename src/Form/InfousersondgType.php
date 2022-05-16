<?php

namespace App\Form;

use App\Entity\Infousersondg;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InfousersondgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('sondage')
            ->add('sexe',ChoiceType::class,[
                'expanded' => true,
                'choices' => [
                    'Femme'=>"Femme",
                    'Homme' =>"Homme",  
                ],
                'attr'=>[
                    'style'=>'display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                ]
                
                
            ])
            ->add('age')
            ->add('pay')
            ->add('email')
            ->add('numTel')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Infousersondg::class,
        ]);
    }
}
