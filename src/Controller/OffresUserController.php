<?php

namespace App\Controller;
use App\Entity\Offres;
use App\Repository\VolRepository;
use App\Entity\Vol;
use App\Entity\User;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Repository\OffersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 * @Route("/promotion")
 */
class OffresUserController extends AbstractController
{
    /**
     * @Route("/offresuser", name="app_offresuser")
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {  
        $nbptsuser=$session->get('user')->getNombreDePoints();
        $iduser=$this->getDoctrine()->getRepository(User::class)->find($session->get('user')->getID());
        $session->get('user');
        $facts = $entityManager->getRepository(Offres::class)->findAll();
        dump($facts);
        return $this->render('offres_user/index.html.twig', [
            'off' => $facts,
            'nbptsuser' => $nbptsuser,
            'iduser' => $iduser,
            'session' => $session,
        ]);
    }
   /**
     * @Route("/offresuser/{destination}", name="app_offresdestination")
     */
    public function offre($destination,EntityManagerInterface $entityManager,SessionInterface $session): Response
    {  
        $session->get('user');
        $facts = $entityManager->getRepository(Reservation::class)->Country($destination);
        dump($facts);
        return $this->render('offres_user/vol.html.twig', [
            'off' => $facts,
            'session' => $session,
        ]);
    }
  
}
