<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Weather;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use App\Repository\ReservationRepository;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Services\QrcodeService;

use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    
    //meteo 
    /**
     * @Route("/weathermobile/{ville}", name="OOOOOOOOOO" , methods={"GET", "POST"})
     */
    public function weathermob($ville, NormalizerInterface $Normalizer): Response
    {
             // Url de l'API

            

   // $url = "https://api.openweathermap.org/data/2.5/weather?q=".$ville."&lang=fr&units=metric&appid=7dc20536ba29bf30592defd78bc8ce10";
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
    $res = new Weather();
    $res->speed=$speed;
    $res->desc=$desc;
    $res->temp=$temp;
    $res->weather=$weather;
    $res->fl=$feel_like;
    

    $jsonContent= $Normalizer->normalize($res,'json' ,['groups' =>'post:read' ] );


    return new Response(json_encode($jsonContent));

    }    

     /**
     * @Route("/newJsonres/new", name="newJsonres")
     */
    public function newJsonres(Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer,SessionInterface $session)
    {
        $session->get('user');
        $reservation = new Reservation();
        $reservation->settype('Individuelle');

            $reservation->setDestination($Request->get('dest'));
            $reservation->setNbrEnfants($Request->get('nbre'));
            $reservation->setNbrAdultes($Request->get('nbra'));
            $reservation->setDateDeb($Request->get('dated'));
            $reservation->setDateFin($Request->get('datef'));
        
            $entityManager->persist($reservation);
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($reservation,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

     /**
     * @Route("/Jsonres/{revId}", name="json_res")
     */
    public function Jsonres($revId, Request $Request, NormalizerInterface $Normalizer,SessionInterface $session){
        $session->get('user');
        //$em->this->getDoctrine()->getManager();
        $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->find($revId);
        $jsonContent= $Normalizer->normalize($reservations,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));


     }

    /**
     * @Route("/AllRes", name="AllRes")
     */

    public function AllRes(NormalizerInterface $Normalizer,SessionInterface $session){
        $session->get('user');
        $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        $jsonContent= $Normalizer->normalize($reservations,'json' ,['groups' =>'post:read' ] );
        return $this->render('reservation/allresjson.html.twig', [
            'data' => $jsonContent,
            'session' => $session,
           ]);


     }
    /**
     * @Route("/weather", name="weather" , methods={"GET", "POST"})
     */
    public function weather(SessionInterface $session): Response
    { $session->get('user');
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

        return $this->render('reservation/weather.html.twig' , ['session' => $session,'raw'=>$raw,'json'=>$json,'name'=>$name,'weather'=>$weather,'desc'=>$desc,'temp'=>$temp,'feel_like'=>$feel_like,'speed'=>$speed,'deg'=>$deg]);
    }


    /**
     * @Route("/vyg", name="vyg", methods={"GET"})
     */
    public function vyg(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
       $reservations = $entityManager
            ->getRepository(Reservation::class)
            
            ->findByType('VoyageOrganise');
          //->find($usr_id) session
          
            

        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations,
            'session' => $session
        ]);
    }
  
    
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'session' => $session,
        ]);
    }

    
    /**
     * @Route("/mesres", name="consulter", methods={"GET"})
     */
    public function consulter(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            $reservations =  $this->getDoctrine()->getRepository(Reservation::class)->findBy(array('ID_user'=>$session->get('user')));
          //  dump($session->getId());
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
           // $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/consulter.html.twig', [
            'reservations' => $reservations,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/sort", name="sorted", methods={"GET"})
     */
    public function sort(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
       /* $reservations = $entityManager
            ->getRepository(Reservation::class)
            //->orderbyprix();
            ->findAll();*/
          
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findByType('Individuelle');
            
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->orderbyprix();
            
            //$reservations =   $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            

        return $this->render('reservation/sort.html.twig', [
            'reservations' => $reservations,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/indiv", name="indiv", methods={"GET"})
     */
    public function indiv(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
       
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->indiv();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/voy", name="voy", methods={"GET"})
     */
    public function voy(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
            $reservations =   $this->getDoctrine()->getRepository(Reservation::class)->voyage();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'session' => $session,
        ]);
    }

    


    
    /**
     * @Route("/trial", name="trial", methods={"GET", "POST"})
     */
    public function try(EntityManagerInterface $entityManager, QrcodeService $qrcodeService,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'sa' => $sa,
            'piechart' => $pieChart ]);
    }


    /**
     * @Route("/oo", name="oo", methods={"GET", "POST"})
     */
    public function oo(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'sa' => $sa,
            'date'=> $dateFormat]);
    }

    /**
     * @Route("/aff", name="aff", methods={"GET", "POST"})
     */
    public function aff(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
       
        
          

        return $this->render('reservation/iheb.html.twig', [
            
            ]);
    }


    /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/reserver", name="reserv_indiv", methods={"GET", "POST"})
     */
    public function reserver(Request $request, EntityManagerInterface $entityManager, QrcodeService $qrcodeService,SessionInterface $session): Response
    {
        $session->get('user');
      //  $omek=$session;
      // $session->set('iduser', 25);
        //$idus=$session->get('iduser');
        $reservation = new Reservation();
        $reservation->settype('Individuelle');
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $reservation->setDestination($form["vol"]->getData());
            $reservation->setIdUser($this->getDoctrine()->getRepository(User::class)->find($session->get('user')->getID()));
            $entityManager->persist($reservation);
            $entityManager->flush();
            $session->set('revID', $reservation->getRevId());
            $volrev=$reservation->getVol();
            $session->set('volid', $volrev);

           // return $this->redirectToRoute('reserv_indiv', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_facture_user', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->render('reservation/reserver.html.twig', [
            'reservation' => $reservation,
            'session' => $session,
           
            'form' => $form->createView(),
            
        ]);
    }

    
    /**
     * @Route("/sms/{revId}", name="sms", methods={"GET"})
     */
    public function sms(Reservation $reservation, QrcodeService $qrcodeService,SessionInterface $session): Response
    {
        $session->get('user');
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('iheb',$reservation);


            $sid    = "AC0c322b9cef5473f69e18c0d8bdf226e3"; 
            $token  = "ecb1006f326ee0803c0592a8da5dba24"; 
            $twilio = new Client($sid, $token); 
            
            $message = $twilio->messages 
                            ->create("+21650480316", // to 
                                    array(  
                                        "messagingServiceSid" => "MG09a0f595a98c1544d6a4068c212ba887",      
                                        "body" => "Voici votre Réservation:  ".$reservation
                                    ) 
                            ); 
            
           // print($message->sid);
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'session' => $session,
            'qrCode' => $qrCode,
        ]);
    }

    /**
     * @Route("/{revId}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation, QrcodeService $qrcodeService,SessionInterface $session): Response
    {
        $session->get('user');
        $qrCode = null;
        $qrCode = $qrcodeService->qrcode('iheb',$reservation);
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'session' => $session,
            'qrCode' => $qrCode,
        ]);
    }

    /**
     * @Route("/{revId}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation,SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $session->get('user');
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/{revId}/editfront", name="app_reservation_edit_front", methods={"GET", "POST"})
     */
    public function customize(Request $request, Reservation $reservation,SessionInterface $session, EntityManagerInterface $entityManager, QrcodeService $qrcodeService): Response
    {
        $session->get('user');
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
            'session' => $session,
            'qrcode'=> $qrCode,
        ]);
    }

     
    

    /**
     * @Route("/{revId}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request,SessionInterface $session, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$reservation->getRevId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{revId}/delete", name="front_delete", methods={"POST"})
     */
    public function deletefront(Request $request, SessionInterface $session,Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$reservation->getRevId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consulter', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }


     /**
     * @Route("/{revId}/annuler", name="annuler", methods={"POST"})
     */
    public function annuler(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getRevId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vyg', [], Response::HTTP_SEE_OTHER);
    }
    


    
}
