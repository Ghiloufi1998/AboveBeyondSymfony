<?php

namespace App\Controller;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\Offres;
use App\Form\OffresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/offres")
 */
class OffresController extends AbstractController
{
    /**
     * @Route("/", name="app_offres_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $offres = $entityManager->getRepository(Offres::class)->findAll();
        return $this->render('offres/index.html.twig', [
            'offres' => $offres,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/new", name="app_offres_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOff}", name="app_offres_show", methods={"GET"})
     */
    public function show(Offres $offre,SessionInterface $session): Response
    {
        $session->get('user');
        return $this->render('offres/show.html.twig', [
            'offre' => $offre,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{idOff}/edit", name="app_offres_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offres $offre, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $form = $this->createForm(OffresType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offres/edit.html.twig', [
            'offre' => $offre,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOff}", name="app_offres_delete", methods={"POST"})
     */
    public function delete(Request $request, Offres $offre, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOff(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offres_index', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }
}
