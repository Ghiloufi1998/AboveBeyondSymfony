<?php

namespace App\Controller;

use App\Entity\Reservation;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use App\Repository\ReservationRepository;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{


    
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }


    
    /**
     * @Route("/trial", name="trial", methods={"GET", "POST"})
     */
    public function try(EntityManagerInterface $entityManager): Response
    {
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
            $reservations =   intval($this->getDoctrine()->getRepository(Reservation::class)->expensive());
            $reservations1 =  intval( $this->getDoctrine()->getRepository(Reservation::class)->cheap());

            $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Nbre Réservations'],
                ['Cheap', $reservations ],
                ['Expensive',  $reservations1]
            ]
        );
        $pieChart->getOptions()->setTitle('Reponse');
            $pieChart->getOptions()->setHeight(500);
            $pieChart->getOptions()->setWidth(900);
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
            $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);



            

        return $this->render('reservation/exp.html.twig', [
            'reservations' => $reservations,
            'reservations1' => $reservations1,
            'piechart' => $pieChart ]);
    }

    /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->settype('Individuelle');
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $reservation->setDestination($form["vol"]->getData());
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/reserver", name="reserv_indiv", methods={"GET", "POST"})
     */
    public function reserver(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->settype('Individuelle');
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $reservation->setDestination($form["vol"]->getData());
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reserv_indiv', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/reserver.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{revId}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{revId}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{revId}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getRevId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
}
