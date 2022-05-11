<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paiment")
 */
class PaiementController extends AbstractController
{
     /**
     * @Route("/getPaiementjson", name="AllPaiements")
     */
    public function getfacture( EntityManagerInterface $entityManager ,NormalizerInterface $normalizer)
    {
        $factures = $entityManager
        ->getRepository(Paiement::class)
        ->findAll();
        $jsonContent=$normalizer->normalize($factures,'json',['groups'=>'post:read']);
        
        
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/getPaiementjson/new", name="NewPaiement")
     */
    public function AddFacture( Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $facture = new Paiement();
        $facture->setDateEch(new \DateTime($request->get("Date")));
        $facture->setMontantTtc($request->get("Montant"));
        $facture->setEtat($request->get("Etat"));
        $entityManager->persist($facture);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($facture,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/", name="app_paiement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $paiements = $entityManager
            ->getRepository(Paiement::class)
            ->findAll();

        return $this->render('paiement/index.html.twig', [
            'paiements' => $paiements,
        ]);
    }

    /**
     * @Route("/new", name="app_paiement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/new.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{paiId}", name="app_paiement_show", methods={"GET"})
     */
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    /**
     * @Route("/{paiId}/edit", name="app_paiement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{paiId}", name="app_paiement_delete", methods={"POST"})
     */
    public function delete(Request $request, Paiement $paiement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getPaiId(), $request->request->get('_token'))) {
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
