<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use App\Repository\ReservationRepository;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

use App\Services\QrcodeService;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{


    /**
     * @Route("/weather", name="weather" , methods={"GET", "POST"})
     */
    public function weather(): Response
    {
             // Url de l'API

             $ville=$_POST["tame"];

    $url = "https://api.openweathermap.org/data/2.5/weather?q=".$ville."&lang=fr&units=metric&appid=7dc20536ba29bf30592defd78bc8ce10";

    // On get les resultat
    $raw = file_get_contents($url);
    // Décode la chaine JSON
    $json = json_decode($raw);

    // Nom de la ville
    $name = $json->name;
    
    // Météo
    $weather = $json->weather[0]->main;
    $desc = $json->weather[0]->description;

    // Températures
    $temp = $json->main->temp;
    $feel_like = $json->main->feels_like;

    // Vent
    $speed = $json->wind->speed;
    $deg = $json->wind->deg;

        return $this->render('reservation/weather.html.twig' , ['raw'=>$raw,'json'=>$json,'name'=>$name,'weather'=>$weather,'desc'=>$desc,'temp'=>$temp,'feel_like'=>$feel_like,'speed'=>$speed,'deg'=>$deg]);
    }
    
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
     * @Route("/mesres", name="consulter", methods={"GET"})
     */
    public function consulter(EntityManagerInterface $entityManager): Response
    {
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByuser(13);
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
           // $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/consulter.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/sort", name="sorted", methods={"GET"})
     */
    public function sort(EntityManagerInterface $entityManager): Response
    {
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/sort.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/indiv", name="indiv", methods={"GET"})
     */
    public function indiv(EntityManagerInterface $entityManager): Response
    {
       
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->indiv();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/voy", name="voy", methods={"GET"})
     */
    public function voy(EntityManagerInterface $entityManager): Response
    {
       
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->voyage();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    


    
    /**
     * @Route("/trial", name="trial", methods={"GET", "POST"})
     */
    public function try(EntityManagerInterface $entityManager, QrcodeService $qrcodeService): Response
    {
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            $avg = $this->getDoctrine()->getRepository(Reservation::class)->avg();
            $reservations =   intval($this->getDoctrine()->getRepository(Reservation::class)->expensive($avg));
            $reservations1 =  intval( $this->getDoctrine()->getRepository(Reservation::class)->cheap($avg));
            //$dest = $this->getDoctrine()->getRepository(Reservation::class)->dest();
            $tot = $this->getDoctrine()->getRepository(Reservation::class)->tot();
            $sa=$tot/12;

            $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Categories', 'Nbre Réservations'],
                ['Cheap', $reservations ],
                ['Expensive',  $reservations1]
            ]
        );
        $pieChart->getOptions()->setTitle('Classification des réservation');
            $pieChart->getOptions()->setHeight(500);
            $pieChart->getOptions()->setWidth(900);
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
            $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


            
            $heb = $this->getDoctrine()->getRepository(Reservation::class)->heber();
            $dest = $this->getDoctrine()->getRepository(Reservation::class)->dest();

           



        return $this->render('reservation/exp.html.twig', [
            'reservations' => $reservations,
            'reservations1' => $reservations1,
            'heb' => $heb,
            'dest' => $dest,
            'avg' => $avg,
            'tot' => $tot,
            'sa' => $sa,
            'piechart' => $pieChart ]);
    }


    /**
     * @Route("/oo", name="oo", methods={"GET", "POST"})
     */
    public function oo(EntityManagerInterface $entityManager): Response
    {
       
        $heb = $this->getDoctrine()->getRepository(Reservation::class)->heber();
        $dest = $this->getDoctrine()->getRepository(Reservation::class)->dest();
        $avg = $this->getDoctrine()->getRepository(Reservation::class)->avg();
        $tot = $this->getDoctrine()->getRepository(Reservation::class)->tot();
        $sa=$tot/12;


            $dateFormat = new DateTime();

          

        return $this->render('reservation/oo.html.twig', [
            
            'dest' => $dest ,
            'avg' => $avg ,
            'heb' => $heb ,
            'tot' => $tot,
            'sa' => $sa,
            'date'=> $dateFormat]);
    }

    /**
     * @Route("/aff", name="aff", methods={"GET", "POST"})
     */
    public function aff(EntityManagerInterface $entityManager): Response
    {
       
        
          

        return $this->render('reservation/iheb.html.twig', [
            
            ]);
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
    public function reserver(Request $request, EntityManagerInterface $entityManager, QrcodeService $qrcodeService): Response
    {
        $reservation = new Reservation();
        $reservation->settype('Individuelle');
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $reservation->setDestination($form["vol"]->getData());
            $reservation->setIdUser($this->getDoctrine()->getRepository(User::class)->find(13));
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
     * @Route("/sms/{revId}", name="sms", methods={"GET"})
     */
    public function sms(Reservation $reservation, QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('iheb',$reservation);


            $sid    = "AC3ea871badadca7b42b05c6fea7f9ae84"; 
            $token  = "298ab71eb0413ee94b4be74b5988caac"; 
            $twilio = new Client($sid, $token); 
            
            $message = $twilio->messages 
                            ->create("+21650480316", // to 
                                    array(  
                                        "messagingServiceSid" => "MG87f9e03c88406cbd61c654d2db8eab04",      
                                        "body" => "Voici votre Réservation:  ".$reservation
                                    ) 
                            ); 
            
           // print($message->sid);
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'qrCode' => $qrCode,
        ]);
    }

    /**
     * @Route("/{revId}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation, QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('iheb',$reservation);
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'qrCode' => $qrCode,
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
     * @Route("/{revId}/editfront", name="app_reservation_edit_front", methods={"GET", "POST"})
     */
    public function customize(Request $request, Reservation $reservation, EntityManagerInterface $entityManager, QrcodeService $qrcodeService): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('iheb',$reservation);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('consulter', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/customize.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
            'qrcode'=> $qrCode,
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

    /**
     * @Route("/{revId}/delete", name="front_delete", methods={"POST"})
     */
    public function deletefront(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getRevId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consulter', [], Response::HTTP_SEE_OTHER);
    }

    
}
