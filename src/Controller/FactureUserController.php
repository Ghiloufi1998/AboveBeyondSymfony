<?php

namespace App\Controller;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FactureUserController extends AbstractController
{
    /**
     * @Route("/user", name="app_facture_user")
     */
    public function index(Request $request,EntityManagerInterface $entityManager,SessionInterface $session): Response
    {  
        $revId=$session->get('revID');
        $factures =$this->getDoctrine()->getRepository(Reservation::class)->showall($revId);
       
      
      //  dump( $factures);
       // dump($x);
         $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);
        $des=$form["modePay"]->getData();
        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($paiement);
            
            $entityManager->flush();
          //  $factures =$this->getDoctrine()->getRepository(Reservation::class)->showall($revId);
            $x =$this->getDoctrine()->getRepository(Reservation::class)->facture($factures);
            $y =$this->getDoctrine()->getRepository(Reservation::class)->Montantfacture($factures);
             if($des=="versement" || $des=="espéce"){
             return $this->redirectToRoute('app_pdf', [], Response::HTTP_SEE_OTHER);
             }
             else{
                return  $this->redirectToRoute('app_pai_user', [], Response::HTTP_SEE_OTHER);
             }
        }

        return $this->render('facture_user/index.html.twig', [
            'paiement' => $paiement,
            'prix'=>$factures,
            'form' => $form->createView(),
        ]);
    }
    
}
