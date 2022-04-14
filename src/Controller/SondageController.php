<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Reponses;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert; 


/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * 
    * @Route("/", name="app_sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $RepositorySondage): Response
    {
        $sondages = $RepositorySondage ->findAll();

        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages,
        ]);
    }


     /**
     * @Route("/list", name="app_sondage_user", methods={"GET"})
     */
    public function ListSondageUser(SondageRepository $RepositorySondage): Response
    {
        $sondages = $RepositorySondage ->findAll();

        return $this->render('sondage/ListSondageUser.html.twig', [
            'sondages' => $sondages,
        ]);
    }


    /**
     * @Route("/new", name="app_sondage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{sondageId}", name="app_sondage_show", methods={"GET"})
     */
  /*  public function show(Sondage $sondage): Response
    {
        return $this->render('questions/index.html.twig', [
            'sondage' => $sondage,
        ]);
    }*/

    /**
     * @Route("/{sondageId}/edit", name="app_sondage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sondage $sondage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{sondageId}", name="app_sondage_delete", methods={"POST"})
     */
    public function delete(Request $request, Sondage $sondage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getSondageId(), $request->request->get('_token'))) {
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
    }


/**
     * @Route("/{sondageId}/showsurvey", name="app_sondage_showsurvey", methods={"GET","POST"})
     */
    public function showAction($sondageId,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        
        $entity = $em->getRepository(Sondage::class)->find($sondageId);
    
       

        $builder = $this->createFormBuilder();

        foreach ($entity->getQuestion() as $question) {
           $type=$question->getType();
            if ($type==='YES/NO' ){
           
            $builder->add('question'.$question->getQuestionId(), ChoiceType::class,[
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
            
           } elseif ($type ==='Text'){
                $builder ->add('question'.$question->getQuestionId(), TextareaType::class,[
                    'label'=>$question->getQuestion(),
                    
                    

                ]);
             }else {//($type ==='Rate'){
                $builder ->add('question'.$question->getQuestionId(),  ChoiceType::class ,[
                    'expanded' => true,
                    'label' => $question->getQuestion(),
                    'choices' => [
                        'One'=>"1",
                        'Two' =>"2",
                        'Three' =>"3",
                        'Four' =>"4",
                        'Five' =>"5",
                    ],
                    'attr'=>[
                        'style'=>'display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                    ]
                 ]) 
                 ;}
                    

               
             }
              
        

        $form = $builder->getForm();
        $form->handleRequest($request);
        $reponse=new Reponses();
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($entity->getQuestion() as $question) {
                $data=$form->getData();
                $reponse=new Reponses();
               // $dataRep=$data['question'.$question->getQuestionId()];
               $reponse->setReponse($data['question'.$question->getQuestionId()]);
                $reponse->setQuestion($question);
                $em->persist($reponse);
                $em->flush();
                
               
            }
            
           /* $reponse=new Reponses( $dataRep,$entity->getQuestion());
            $em->persist($reponse);
                    $em->flush();*/
            return $this->redirectToRoute('app_sondage_user', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('sondage/SubmitSondage.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }


  
}
