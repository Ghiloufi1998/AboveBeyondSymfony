<?php

namespace App\Form;

use App\Entity\Reponses;
use App\Entity\Sondage;
use App\Entity\Questions;

use App\Repository\QuestionsRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReponsesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   /* $sondage = $options['data']->getQuestion() ;//->getSondage();

            $questions = $sondage->getValues();
        
        
        $i=1;
        if (is_array($questions) || is_object($questions))
{
        foreach($questions as $question){
           $type=$question->getType();
           if ($type ==='Rate' ){
                $builder ->add('reponse', ChoiceType::class,[
                'expanded' => true,
                'label' => $question->getQuestion(),
                'choices' => [
                    'Yes'=>"Yes",
                    'No' =>"No",
                ],
                'attr'=>[
                    'style'=>'display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                ]
             ]) 
             ;
            
           } elseif ($type ==="Text"){
                $builder ->add('reponse', ChoiceType::class,[
                    'label'=>$question->getQuestion(),
                    'choices' => [
                        'Yes'=>"Yes",
                        'No' =>"No",
                    ],

                ]);
             }
                //->add('question')
       }

    }*/
}
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponses::class,
        ]);
    }
}
