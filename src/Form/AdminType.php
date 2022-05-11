<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adminname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('birthday',DateType::class)
            ->add('gender',ChoiceType::class,[
                'choices' =>[
                    '' =>[
                        'Male' =>'Male',
                        'Female' =>'Female',
                    ],
                ],
            ])        
            ->add('tel',IntegerType::class)
            ->add('email',EmailType::class)
            ->add('password',PasswordType::class)
            ->add('image', FileType::class, array('data_class'=>null,'required'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
