<?php

namespace App\Controller;

use App\Entity\Voyageorganise;
use App\Entity\Reservation;
use \Datetime;
use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Form\VoyageorganiseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/voyageorganise")
 */
class VoyageorganiseController extends AbstractController
{
    /**
     * @Route("/", name="app_voyageorganise_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $voyageorganises = $entityManager
            ->getRepository(Voyageorganise::class)
            ->findAll();

        return $this->render('voyageorganise/index.html.twig', [
            'voyageorganises' => $voyageorganises,
            'session' => $session,
        ]);
    }
    /**
     * @Route("/afficher", name="index1", methods={"GET"})
     */
    public function index1(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $voyageorganises = $entityManager
            ->getRepository(Voyageorganise::class)
            ->findAll();

        return $this->render('voyageorganise/index1.html.twig', [
            'voyageorganises' => $voyageorganises,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/res{voyageId}", name="resvoy", methods={"GET"})
     */
    public function reserver(Request $request, EntityManagerInterface $entityManager,SessionInterface $session,Voyageorganise $voyageorganise,FlashyNotifier $flashy,MailerInterface $mailer): Response
    {
        $session->get('user');
        if(($voyageorganise->getNbrePlaces() ) >0)  {
        $reservation= new Reservation();
        $reservation->settype('VoyageOrganise');
        $reservation->setNbrAdultes(1);
        $reservation->setVol($voyageorganise->getVol());
        $reservation->setIdUser($this->getDoctrine()->getRepository(User::class)->find($session->get('user')->getID()));
        $reservation->setDestination($voyageorganise->getVol()->getDestination());
        $reservation->setNbrEnfants(0);
        $date = new \DateTime('@'.strtotime('now'));
        
        $voyageorganise->setNbrePlaces( ($voyageorganise->getNbrePlaces() )-1 );

        // $date = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now'));
        $reservation->setDateDeb($date);
        $reservation->setDateFin( $date);
        $email=$reservation->getIdUser()->getEmail();
        
        $entityManager->persist($reservation);
        $entityManager->flush();
        $email = (new Email())
                ->from('pidevarcane@gmail.com')
                ->to($email)
           //->cc('cc@example.com')
//->bcc('bcc@example.com')
//->replyTo('fabien@example.com')
//->priority(Email::PRIORITY_HIGH)
                ->subject('Reservation ')
                ->text('Bienvenue')
                ->html('<div style="border:2px solid blue ;"> <h1>Bonjour,Votre reservation est faite avec sucés!</h1>   
</div>');

            /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
            $sentEmail = $mailer->send($email);
// $messageId = $sentEmail->getMessageId();

// ...
        $flashy->success('Votre réservation est faite avec succés ! ');
    }
        return $this->redirectToRoute('index1', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
           


       /* return $this->render('voyageorganise/index1.html.twig', [
            'voyageorganises' => $voyageorganises,
        ]);*/
    }


    /**
     * @Route("/new", name="app_voyageorganise_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $voyageorganise = new Voyageorganise();
        $form = $this->createForm(VoyageorganiseType::class, $voyageorganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $voyageorganise->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $voyageorganise->setImage("http://127.0.0.1:8000/uploads/" .$fileName);
                // ... handle exception if something happens during file upload
        
            $entityManager = $this->getDoctrine()->getManager();
            $voyageorganise->setImage($fileName);
            $entityManager->persist($voyageorganise);
            $entityManager->flush();


            return $this->redirectToRoute('app_voyageorganise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyageorganise/new.html.twig', [
            'voyageorganise' => $voyageorganise,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{voyageId}", name="app_voyageorganise_show", methods={"GET"})
     */
    public function show(Voyageorganise $voyageorganise,SessionInterface $session): Response
    {
        $session->get('user');
        return $this->render('voyageorganise/show.html.twig', [
            'voyageorganise' => $voyageorganise,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/{voyageId}/edit", name="app_voyageorganise_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Voyageorganise $voyageorganise,SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $session->get('user');
        $form = $this->createForm(VoyageorganiseType::class, $voyageorganise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voyageorganise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voyageorganise/edit.html.twig', [
            'voyageorganise' => $voyageorganise,
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{voyageId}", name="app_voyageorganise_delete", methods={"POST"})
     */
    public function delete(Request $request, Voyageorganise $voyageorganise,SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$voyageorganise->getVoyageId(), $request->request->get('_token'))) {
            $entityManager->remove($voyageorganise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voyageorganise_index', [
            'session' => $session,
        ], Response::HTTP_SEE_OTHER);
    }
 
}