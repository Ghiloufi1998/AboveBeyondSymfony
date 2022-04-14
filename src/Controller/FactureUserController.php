<?php

namespace App\Controller;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\Paiement;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FactureUserController extends AbstractController
{
    /**
     * @Route("/user", name="app_facture_user")
     */
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {  $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('app_pai_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture_user/index.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }
}
