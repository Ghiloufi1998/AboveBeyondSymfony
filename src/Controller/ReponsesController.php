<?php

namespace App\Controller;

use App\Entity\Reponses;
use App\Form\ReponsesType;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/reponses")
 */
class ReponsesController extends AbstractController
{
    /**
     * @Route("/", name="app_reponses_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reponses = $entityManager
            ->getRepository(Reponses::class)
            ->findAll();

        return $this->render('reponses/index.html.twig', [
            'reponses' => $reponses,
        ]);
    }

    /**
     * @Route("/AllReponse/{questionId}", name="rep" )
     */

   public function ShowReponse(NormalizerInterface $Normalizer,$questionId){
        $q =   $this->getDoctrine()->getRepository(Reponses::class)->findByQstId($questionId);
        $jsonContent= $Normalizer->normalize($q,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));



     }
     /**
     * @Route("/statt", name="app_reponses_stat", methods={"GET"})
     */
   public function statistique(ReponsesRepository $repo): Response
    {
           $reponses = $repo->findAll();
           foreach($reponses as $reponse){
           $sondNom[]= $reponse->getQuestion()->getSondage()->getSujet();
           $question[]=$reponse->getQuestion();
           dd($reponse);}

    }


    /**
     * @Route("/new", name="app_reponses_new", methods={"GET", "POST"})
     */
   public function new( Request $request, EntityManagerInterface $entityManager): Response
    {
      //  $questions = $repo->findById($sondageId);
        $reponse = new Reponses();
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponse);
            $entityManager->flush();

            return $this->redirectToRoute('app_reponses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponses/new.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    
    

    /**
     * @Route("/{reponsesId}", name="app_reponses_show", methods={"GET"})
     */
    public function show(Reponses $reponse): Response
    {
        return $this->render('reponses/show.html.twig', [
            'reponse' => $reponse,
        ]);
    }

    /**
     * @Route("/{reponsesId}/edit", name="app_reponses_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reponses $reponse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponsesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reponses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponses/edit.html.twig', [
            'reponse' => $reponse,
            'form' => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/{reponsesId}", name="app_reponses_delete", methods={"POST"})
     */
    public function delete(Request $request, Reponses $reponse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponse->getReponsesId(), $request->request->get('_token'))) {
            $entityManager->remove($reponse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reponses_index', [], Response::HTTP_SEE_OTHER);
    }
  
}
