<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaiementUserController extends AbstractController
{
    /**
     * @Route("/userpai", name="app_pai_user")
     */
    public function index(): Response
    {
        return $this->render('paiement_user/index.html.twig', [
            'controller_name' => 'PaiementUserController',
        ]);
    }
}
