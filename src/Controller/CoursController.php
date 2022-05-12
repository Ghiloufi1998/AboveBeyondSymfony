<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/cours")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/", name="app_cours_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findAll();

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
            'session' => $session,
        ]);
    }
    /**
     * @Route("/listeguide/consulter/{idG}", name="coursbyidg", methods={"GET"})
     */
    public function consulter(EntityManagerInterface $entityManager,$idG,SessionInterface $session): Response
    {
        $session->get('user');
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findByIdG($idG);

        return $this->render('cours/consultebyguide.html.twig', [
            'cours' => $cours,
            'session' => $session,
        ]);
    }
    /**
     * @Route("/showg/{idG}", name="coursidg", methods={"GET"})
     */
    public function consulterg(EntityManagerInterface $entityManager,$idG,SessionInterface $session): Response
    {
        $session->get('user');
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findByIdG($idG);

        return $this->render('cours/coursidg.html.twig', [
            'cours' => $cours,
            'session' => $session,
        ]);
    }
    /**
     * @Route("/listeguide/prendre/{idCrs}", name="prendrecours", methods={"GET"})
     */
    public function prendre(EntityManagerInterface $entityManager,$idCrs,SessionInterface $session): Response
    {
        $session->get('user');
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findByidCrs($idCrs);

        return $this->render('cours/courstakebyguide.html.twig', [
            'cours' => $cours,
            'session' => $session,
        ]);
    }
    /**
     * @Route("/new", name="app_cours_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $cour->setImage("http://127.0.0.1:8000/uploads/" .$fileName);
            $entityManager->persist($cour);
           
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCrs}", name="app_cours_show", methods={"GET"})
     */
    public function show(Cours $cour,SessionInterface $session): Response
    {
        $session->get('user');
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{idCrs}/edit", name="app_cours_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $cour->setImage("http://127.0.0.1:8000/uploads/" .$fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCrs}", name="app_cours_delete", methods={"POST"})
     */
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$cour->getIdCrs(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
