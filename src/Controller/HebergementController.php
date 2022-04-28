<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Form\HebergementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/hebergement")
 */
class HebergementController extends AbstractController
{
    /**
     * @Route("/", name="app_hebergement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $hebergements = $entityManager
            ->getRepository(Hebergement::class)
            ->findAll();

        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    /**
     * @Route("/hotels", name="hotels", methods={"GET"})
     */
    public function hotels(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator): Response
    {
        $hebergements = $entityManager
            ->getRepository(Hebergement::class)
            ->findAll();

        $hebergements = $paginator->paginate(
                $hebergements,
    
                $request->query->getInt('page', 1),
                3
                // Items per page
    
            );    

        return $this->render('hebergement/afficher.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    /**
     * @Route("/new", name="app_hebergement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $hebergement->setImage($fileName);
            $entityManager->persist($hebergement);
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/new.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hebergementId}", name="app_hebergement_show", methods={"GET"})
     */
    public function show(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/consulter/{hebergementId}", name="consulter", methods={"GET"})
     */
    public function consulter(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/consulter.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/{hebergementId}/edit", name="app_hebergement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $hebergement->setImage($fileName);
            
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/edit.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hebergementId}", name="app_hebergement_delete", methods={"POST"})
     */
    public function delete(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hebergement->getHebergementId(), $request->request->get('_token'))) {
            $entityManager->remove($hebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
    }
}