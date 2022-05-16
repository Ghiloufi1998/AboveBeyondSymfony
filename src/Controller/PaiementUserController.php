<?php

namespace App\Controller;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\Paiement;
use App\Entity\Facture;
use App\Form\PaiementType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
class PaiementUserController extends AbstractController
{   

  //  public static $revId=100;

    /**
     * @Route("/userpai", name="app_pai_user")
     */
    public function index(SessionInterface $session): Response
    {  
         //      $revId=$session->get('revID');
         $session->get('user');
        return $this->render('paiement_user/index.html.twig', [
            'controller_name' => 'PaiementUserController',
            'session' => $session,
        ]);
      
    }
    
    
    public function checkout($stripeSK,SessionInterface $session): Response
    {
        Stripe::setApiKey('sk_test_51KmKWhIjCgh8cO6E1SuEySiPhcghjaTLXoHqevuIQY6OgcXtiZDu58ewS8WRzWEckk9hTvRgmvTRWBjeepqvzqnE0037lwOwme');
        
        $montant =$this->getDoctrine()->getRepository(Reservation::class)->showall($session->get('revID'));
        
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'EUR',
                        'product_data' => [
                            'name' => 'Votre Voyage',
                        ],
                        'unit_amount'  =>  $montant*100,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }
   
    public function successUrl(FlashyNotifier $flashy, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {$session->get('user');
        $revId=$session->get('revID');
        $repo=$this->getDoctrine()->getRepository(Facture::class);
        $fact=$repo->findOneByrev($revId);
        $fact->setEtat('payee');
        $entityManager->flush();
        //$prix =$this->getDoctrine()->getRepository(Reservation::class)->payer($revId);
        $flashy->success('Transaction réussite !', 'http://your-awesome-link.com');
        return $this->render('paiement_user/success.html.twig', ['session' => $session,]);
    }
   
     public function cancelUrl(FlashyNotifier $flashy): Response
    {
        $flashy->error('Transaction échoue !', 'http://your-awesome-link.com');
        return $this->render('paiement_user/cancel.html.twig', []);
    }
  
   

     
}