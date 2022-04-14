<?php

namespace App\Controller;
use App\Entity\Offres;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Repository\OffersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/promotion")
 */
class OffresUserController extends AbstractController
{
    /**
     * @Route("/offresuser", name="app_offresuser")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {  
        $facts = $entityManager->getRepository(Offres::class)->findAll();
        dump($facts);
        return $this->render('offres_user/index.html.twig', [
            'off' => $facts,
        ]);
    }
      /**
     * @Route("/", name="app_facture_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager): Response
    {
        $factures = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('offres_user/vol.html.twig', [
            'factures' => $factures,
        ]);
    }
}
