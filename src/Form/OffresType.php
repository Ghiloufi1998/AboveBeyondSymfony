<?php

namespace App\Form;
use App\Entity\Vol;
use App\Entity\Offres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('nbPointReq')
            ->add('destination',EntityType::class, [
                'class' => Vol::class,
                'placeholder' => "(Please select an option.)",
                'choice_label' => 'destination'])
            ->add('pourcentageRed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
