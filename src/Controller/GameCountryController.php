<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameCountryController extends AbstractController
{
    /**
     * @Route("/game", name="app_game_country")
     */
    public function index(SessionInterface $session): Response
    {
        $session->get('user');
        return $this->render('game_country/index.html.twig', [
            'controller_name' => 'GameCountryController',
            'session' => $session,

        ]);
    }
    /**
     * @Route("/score/{score}", name="app_game_score")
     */
    public function score($score,SessionInterface $session):Response    
    {
        $session->get('user');
     

     return $this->redirectToRoute('app_offresuser', [
        'session' => $session,
     ], Response::HTTP_SEE_OTHER);
        
       
    }
}
