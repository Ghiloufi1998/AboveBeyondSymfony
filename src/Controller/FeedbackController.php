<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FeedbackRepository;
use App\Form\FeedbackType;
use App\Entity\Feedback;
use App\Repository\CommentLikesRepository;
use Doctrine\ORM\EntityManagerInterface;


  /**
     * @Route("/feedback", name="app_feedback")
     */
class FeedbackController extends AbstractController
{



      /**
     * @Route("/{id}/", name="kkk", methods={"GET", "POST"})
     */
    public function like(Request $request,  $id ,FeedbackRepository $repfeed ,CommentLikesRepository $repc , EntityManagerInterface $entityanager): Response
    {
        
       $c=new CommentLikes();
      $f= $repfeed->find($id);
            $c->setFeedback($f);
            $entityManager->persist($c);
            $entityManager->flush();
            $f->setNbrLikes(getNbrLikes()+1);
         
        return $this->render('Sondage/listSondageUser.html.twig');
    }

    /**
     * @Route("/", name="app_feedback_index")
     */
    public function index(): Response
    {
        return $this->render('feedback/index.html.twig', [
            'controller_name' => 'FeedbackController',
        ]);
    }

     

        /**
     * @Route("/new", name="app_feedback_new")
     */
    public function new(FeedbackRepository $repfeed ,Request $request):Response
    {
        $feedbacks=$repfeed->findAll();
        $feedback = new Feedback();
        $form= $this->createForm(FeedbackType::class,$feedback);
              foreach($feedbacks as $fd){
                  if(!empty($fd)){
                   $commentaire[]=$fd->getCommentaire();
                  }else{
                      $Commentaire[]="";
                  }
              
              }
             
              $form->handleRequest($request);
              if ($form->isSubmitted() && $form->isValid()) {
                  $feedback->setCreated_at(new \Date());
                  $entityManager->persist($feedback);
                  $entityManager->flush();
      
                  return $this->redirectToRoute('app_sondage_user', [], Response::HTTP_SEE_OTHER);
              }
              return $this->render('sondage/ListSondageUser.html.twig', [
                'form' => $form->createView(),
                'commentaire'=>$commentaire,
            ]);
           
    }

  
}
