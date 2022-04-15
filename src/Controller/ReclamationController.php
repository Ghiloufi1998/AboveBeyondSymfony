<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\UserRepository;
use App\Repository\ReclamationRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReclamationController extends AbstractController
{
   
     /**
     * @Route("/reclamation", name="reclamation")
     */
    public function reclamation(Request $request,SessionInterface $session,UserRepository $userRepository)
    {
        $Reclamation = new Reclamation();
        $form=$this->createForm(ReclamationType::Class,$Reclamation);
        $form->add('Send', SubmitType::class);
        $user = $userRepository->find($session->get('user')->getID());

        $form->handleRequest($request);


        $Reclamation->setUser($user);
       if ($form->isSubmitted()){
        $Reclamation = $form->getData();
        $em=$this->getDoctrine()->getManager();

        $em->persist($Reclamation);
        $em->flush();
        return $this->redirectToRoute('listRec');
}
           return $this->render('reclamation/reclamation.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);
    }

    /**
     * @Route("/listRec", name="listRec")
     */
    public function listReclamation(SessionInterface $session,Request $request , PaginatorInterface $paginator ): Response

   {
    
    if($session->has('user')){
        $repository=$this->getDoctrine()->getRepository(Reclamation::Class);
    $Reclamations=$repository->findBy(array('user'=>$session->get('user')));
    $reclamations = $paginator->paginate(
        $Reclamations,
        $request->query->getInt('page',1),
       
    );
        return $this->render('reclamation/listRec.html.twig', [
            'session' => $session,
            'Reclamations' => $reclamations,
        ]);
    }
    else{
        return $this->redirectToRoute('login');
    }
    
    
    }

    /**
     * @Route("/updatereclamation/{id}", name="updatereclamation")
     */
    public function updatereclamation(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository(Reclamation::class)->find($id);
        $form = $this->createForm(ReclamationType::class, $Reclamation);
        
        $form->add('Modifier',SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('listRec');
        }

        return $this->render('reclamation/updateReclamation.html.twig', [
                        'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deletereclamation/{id}", name="deletereclamation")
     */
    public function deleteReclamation($id)
    {
      
        $em=$this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->Remove($Reclamation);
         $em->flush();

           return $this->redirectToRoute('listRec');

    }

    /**
     * @Route("/showreclamation/{id}", name="showreclamation")
     */

    public function showreclamation($id): Response
    {
        $repository=$this->getDoctrine()->getRepository(Reclamation::Class);
        $Reclamation=$repository->find($id);

        return $this->render('reclamation/showReclamation.html.twig', [
            'Reclamation' => $Reclamation,
        ]);
}
 /**
     * @Route("/listrecBack", name="listrecBack")
     */
    public function listrecBack()

   {
    $repository=$this->getDoctrine()->getRepository(Reclamation::Class);
    $Reclamations=$repository->findAll();

    return $this->render('reclamation/listrecBack.html.twig', [
        
        'Reclamations' => $Reclamations,
    ]);
    
    }
 /**
     * @Route("/showreclamationBack/{id}", name="showreclamationBack")
     */

    public function showreclamationBack($id): Response
    {
        $repository=$this->getDoctrine()->getRepository(Reclamation::Class);
        $Reclamation=$repository->find($id);

        return $this->render('reclamation/showreclamationBack.html.twig', [
            'Reclamation' => $Reclamation,
        ]);
}




    /**
     * @Route("/deletereclamationBack/{id}", name="deletereclamationBack")
     */
    public function deletereclamationBack($id)
    {
      
        $em=$this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository(Reclamation::class)->find($id);
        $em->Remove($Reclamation);
         $em->flush();

           return $this->redirectToRoute('listrecBack');

    }
    
   
}
