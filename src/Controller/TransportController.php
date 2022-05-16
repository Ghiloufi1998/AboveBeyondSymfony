<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/transport")
 */
class TransportController extends AbstractController
{
    /**
     * @Route("/", name="app_transport_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->has('user');
        $transports = $entityManager
            ->getRepository(Transport::class)
            ->findAll();

        return $this->render('transport/index.html.twig', [
            'transports' => $transports,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/new", name="app_transport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->has('user');
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $transport->setImage($fileName);
            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transport/new.html.twig', [
            'transport' => $transport,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

   

    /**
     * @Route("/{transportId}", name="app_transport_show", methods={"GET"})
     */
    public function show(Transport $transport,SessionInterface $session): Response
    {
        $session->has('user');
        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{transportId}/edit", name="app_transport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transport $transport,SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $session->has('user');
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $transport->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transport/edit.html.twig', [
            'transport' => $transport,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{transportId}", name="app_transport_delete", methods={"POST"})
     */
    public function delete(Request $request,SessionInterface $session, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        $session->has('user');
        if ($this->isCsrfTokenValid('delete'.$transport->getTransportId(), $request->request->get('_token'))) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transport_index', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }
}
