<?php

namespace App\Controller;

use App\Entity\Voyageorganise;
use App\Entity\Reservation;
use \Datetime;

use App\Form\VoyageorganiseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyageorganise")
 */
class VoyageorganiseController extends AbstractController
{
    /**
     * @Route("/", name="app_voyageorganise_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voyageorganises = $entityManager
            ->getRepository(Voyageorganise::class)
            ->findAll();

        return $this->render('voyageorganise/index.html.twig', [
            'voyageorganises' => $voyageorganises,
        ]);
    }
    /**
     * @Route("/afficher", name="index1", methods={"GET"})
     */
    public function index1(EntityManagerInterface $entityManager): Response
    {
        $voyageorganises = $entityManager
            ->getRepository(Voyageorganise::class)
            ->findAll();

        return $this->render('voyageorganise/index1.html.twig', [
            'voyageorganises' => $voyageorganises,
        ]);
    }

    /**
     * @Route("/res{voyageId}", name="resvoy", methods={"GET"})
     */
    public function reserver(Request $request, EntityManagerInterface $entityManager,Voyageorganise $voyageorganise): Response
    {
        $reservation= new Reservation();
        $reservation->settype('VoyageOrganise');
        $reservation->setNbrAdultes(1);
        $reservation->setVolId($voyageorganise->getVol()->getVolId());
        $reservation->setDestination($voyageorganise->getVol()->getDestination());
        $reservation->setNbrEnfants(0);
        $date = new \DateTime('@'.strtotime('now'));
        $voyageorganise->setNbrePlaces( ($voyageorganise->getNbrePlaces() )-1 );

        // $date = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now'));
        $reservation->setDateDeb($date);
        $reservation->setDateFin( $date);
        
        $entityManager->persist($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('index1', [], Response::HTTP_SEE_OTHER);


       /* return $this->render('voyageorganise/index1.html.twig', [
            'voyageorganises' => $voyageorganises,
        ]);*/
    }


    /**
     * @Route("/new", name="app_voyageorganise_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voyageorganise = new Voyageorganise();
        $form = $this->createForm(VoyageorganiseType::class, $voyageorganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voyageorganise);
            $entityManager->flush();

            return $this->redirectToRoute('app_voyageorganise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyageorganise/new.html.twig', [
            'voyageorganise' => $voyageorganise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{voyageId}", name="app_voyageorganise_show", methods={"GET"})
     */
    public function show(Voyageorganise $voyageorganise): Response
    {
        return $this->render('voyageorganise/show.html.twig', [
            'voyageorganise' => $voyageorganise,
        ]);
    }

    /**
     * @Route("/{voyageId}/edit", name="app_voyageorganise_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voyageorganise $voyageorganise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoyageorganiseType::class, $voyageorganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voyageorganise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyageorganise/edit.html.twig', [
            'voyageorganise' => $voyageorganise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{voyageId}", name="app_voyageorganise_delete", methods={"POST"})
     */
    public function delete(Request $request, Voyageorganise $voyageorganise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyageorganise->getVoyageId(), $request->request->get('_token'))) {
            $entityManager->remove($voyageorganise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voyageorganise_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
