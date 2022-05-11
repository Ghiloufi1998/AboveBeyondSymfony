<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameCountryController extends AbstractController
{
    /**
     * @Route("/game", name="app_game_country")
     */
    public function index(): Response
    {
        return $this->render('game_country/index.html.twig', [
            'controller_name' => 'GameCountryController',

        ]);
    }
    /**
     * @Route("/score/{score}", name="app_game_score")
     */
    public function score($score):Response    
    {
        
     

     return $this->redirectToRoute('app_offresuser', [], Response::HTTP_SEE_OTHER);
        
       
    }
}
