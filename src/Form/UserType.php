<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('fname',TextType::class)
            
            ->add('gender',ChoiceType::class,[
                'choices' =>[
                    '' =>[
                        'Male' =>'Male',
                        'Female' =>'Female',
                    ],
                ],
            ])        
            ->add('num',IntegerType::class)
            ->add('email',EmailType::class)
            ->add('image', FileType::class, array('data_class'=>null,'required'=>false))
            ->add('password',PasswordType::class)
            ->add('confirmpassword',PasswordType::class)
            ->add('birthday',DateType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
