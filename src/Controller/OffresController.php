<?php

namespace App\Controller;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\Offres;
use App\Form\OffresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;  
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offres")
 */
class OffresController extends AbstractController
{
    
    /**
     * @Route("/AllOffresjson", name="AllOffres")
     */
    public function getOffres( EntityManagerInterface $entityManager ,NormalizerInterface $normalizer)
    {
        $factures = $entityManager
        ->getRepository(Offres::class)
        ->findAll();
        $jsonContent=$normalizer->normalize($factures,'json',['groups'=>'post:read']);
        
      /*  return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
   return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/AllOffres/new", name="NewOffres")
     */
    public function AddOffres( Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $facture = new Offres();
        $facture->setDescription(($request->get("description")));
        $facture->setNbPointReq($request->get("nbPointReq"));
        $facture->setDestination($request->get("destination"));
        $facture->setPourcentageRed($request->get("pourcentageRed"));
        $entityManager->persist($facture);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($facture,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/AllOffres/Update/{id}", name="UpdateOffres")
     */
    public function UpFacture($id, Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $facture = $entityManager
        ->getRepository(Offres::class)
        ->find($id);
        $facture->setDescription(($request->get("description")));
        $facture->setNbPointReq($request->get("nbPointReq"));
        $facture->setDestination($request->get("destination"));
        $facture->setPourcentageRed($request->get("pourcentageRed"));
        $entityManager->persist($facture);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($facture,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response("Modification".json_encode($jsonContent));


    }
    /**
     * @Route("/AllOffres/Del/{id}", name="delOffres")
     */
    public function DelFacture($id, Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $facture = $entityManager
        ->getRepository(Offres::class)
        ->find($id);
        $entityManager->remove($facture);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($facture,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response("supprimer".json_encode($jsonContent));


    }

    /**
     * @Route("/", name="app_offres_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager->getRepository(Offres::class)->findAll();
        return $this->render('offres/index.html.twig', [
            'offres' => $offres,
        ]);
    }

    /**
     * @Route("/new", name="app_offres_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
       
        $offre = new Offres();
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offres/new.html.twig', [
    
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOff}", name="app_offres_show", methods={"GET"})
     */
    public function show(Offres $offre): Response
    {
        return $this->render('offres/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    /**
     * @Route("/{idOff}/edit", name="app_offres_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offres $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offres/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOff}", name="app_offres_delete", methods={"POST"})
     */
    public function delete(Request $request, Offres $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOff(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
    }
}
