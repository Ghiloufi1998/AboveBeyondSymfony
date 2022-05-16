<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Entity\Sondage;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use App\Repository\SondageRepository;
use App\Repository\ReponsesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/questions")
 */
class QuestionsController extends AbstractController
{

  

    /**
     * @Route("/", name="app_questions_index", methods={"GET"})
     */
    public function index(QuestionsRepository $QuestionsRepository,SessionInterface $session): Response
    {
        $questions = $QuestionsRepository
            ->findAll();

        return $this->render('questions/index.html.twig', [
            'questions' => $questions,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/newJsonQuest/new", name="newJsonQst",methods={"GET"})
     * 
     */
    public function newJsonQuest(Request $Request, EntityManagerInterface $entityManager,SessionInterface $session, NormalizerInterface $Normalizer)
    {
        $q = new Questions ();
        
          //  $q->setSondage()->setSondageId($Request->get('sondg'));
            $q->setQuestion($Request->get('qst'));
            $q->setType($Request->get('type'));
            $idSondage=$Request->get('sdjId');
            $q->setSondage($this->getDoctrine()->getRepository(Sondage::class)->find($idSondage));
           
        
            $entityManager->persist($q);
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($q,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updatejsons/{questionId}", name="upqst")
     */
    public function updatejsonsond($questionId,Request $Request,SessionInterface $session, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $q = $this->getDoctrine()->getRepository(Questions::class)->find($questionId);
        

            $q->setQuestion($Request->get('qst'));
            $q->setType($Request->get('type'));
            
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($q,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deletejsonqst/{questionId}", name="deletsondageId")
     */
    public function deletejsonsond($questionId,Request $Request,SessionInterface $session, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $q = $this->getDoctrine()->getRepository(Questions::class)->find($questionId);
        

        $entityManager->remove($q);
        $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($q,'json' ,['groups' =>'post:read' ] );
        return new Response("deleted".json_encode($jsonContent));
    }



    /**
     * @Route("/Jsonhbr/{hebergementId}", name="json_hbr")
     */
    public function Jsonres($hebergementId, Request $Request,SessionInterface $session, NormalizerInterface $Normalizer){
        
        //$em->this->getDoctrine()->getManager();
        $h =   $this->getDoctrine()->getRepository(Hebergement::class)->find($hebergementId);
        $jsonContent= $Normalizer->normalize($h,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));


     }

    /**
     * @Route("/AllQuestion", name="allqst" )
     */

    public function AllQuestion(NormalizerInterface $Normalizer,SessionInterface $session){
        $q =   $this->getDoctrine()->getRepository(Questions::class)->findAll();
        $jsonContent= $Normalizer->normalize($q,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));



     }

    /**
     * @Route("/new", name="app_questions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $question = new Questions();
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/new.html.twig', [
            'question' => $question,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{questionId}", name="app_questions_show", methods={"GET"})
     */
    public function show(Questions $question,SessionInterface $session): Response
    {
        return $this->render('questions/show.html.twig', [
            'question' => $question,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{questionId}/edit", name="app_questions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Questions $question,SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionsType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('questions/edit.html.twig', [
            'question' => $question,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    


    /**
     * @Route("/{questionId}", name="app_questions_delete", methods={"POST"})
     */
    public function delete(Request $request, Questions $question, SessionInterface $session,EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getQuestionId(), $request->request->get('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sondage_index', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }

    

      /**
     * @Route("/display/{sondageId}" , name="app_sondage_display")
     */
    public function listQuestion(QuestionsRepository $repo, $sondageId,SessionInterface $session): Response
    {

       $questions = $repo->findById($sondageId);

        
        return $this->render('questions/index.html.twig', [
            'questions' => $questions,
            'session' => $session,
            
        ]);
    }

   
}
