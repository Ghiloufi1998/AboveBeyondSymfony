<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDeb')
            ->add('dateFin')
            /*->add('type', ChoiceType::class,[
                'choices' => [
                    'Individuelle' => true,
                    'Voyage' => false,
                ],
            ])*/
            ->add('nbrAdultes')
            ->add('nbrEnfants')
            //->add('destination')
            ->add('hebergement')
            ->add('vol')
            //->add('idUser')
            //
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
