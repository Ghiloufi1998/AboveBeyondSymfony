<?php

namespace App\Controller;
use App\Entity\Paiement;
use App\Entity\Facture;

use App\Repository\FactureRepository;
use App\Repository\PaiementRepository;

use App\Form\FactureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="app_facture_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $factures = $entityManager
            ->getRepository(Facture::class)
            ->findAll();
           
        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
        ]);
    }

    /**
     * @Route("/new", name="app_facture_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idFac}", name="app_facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{idFac}/edit", name="app_facture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idFac}", name="app_facture_delete", methods={"POST"})
     */
    public function delete($idFac,Request $request, Facture $facture, EntityManagerInterface $entityManager,FactureRepository $FR,PaiementRepository $PaiementRepository): Response
    {
           $x=$PaiementRepository->find($idFac);

           $entityManager->remove($facture);
            $entityManager->remove($x);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_facture_index', [], Response::HTTP_SEE_OTHER);
    }
}
