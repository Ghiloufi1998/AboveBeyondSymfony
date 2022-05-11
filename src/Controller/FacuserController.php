<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacuserController extends AbstractController
{
    /**
     * @Route("/facuser", name="app_facuser")
     */
    public function index(): Response
    {
        return $this->render('facuser/index.html.twig', [
            'controller_name' => 'FacuserController',
        ]);
    }
}
