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
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Hebergement;
use Symfony\Component\Filesystem\Filesystem;
/**
 * @Route("/transport")
 */
class TransportController extends AbstractController
{
    
     /**
     * @Route("/findth/{hebergementId}", name="json_vth")
     */
    public function Jsonres($hebergementId, Request $Request, NormalizerInterface $Normalizer){
        
        //$em->this->getDoctrine()->getManager();
        $h=$this->getDoctrine()->getRepository(Transport::class)->findByhebergement($hebergementId);
        
        $jsonContent= $Normalizer->normalize($h,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));


     }
    
    /**
     * @Route("/newJsont/new", name="newJsonhbr")
     */
    public function newJsont(Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $hbr = new Transport();
        

            $hbr->setType($Request->get('type'));
            $hbr->setDisponibilite($Request->get('dis'));
            $hbr->setDescription($Request->get('desc'));
            //$hbr->setAdresse($Request->get('ad'));
            $fileNamePhoto=$Request->get('im');
            $filePathMobilePhoto="file://C://Users//Ghiloufi//AppData//Local//Temp";
           // $filePathMobilePhoto=$Request->get('image');
            $uploads_directoryPic = $this->getParameter('images_directory');
            $filesystempic = new Filesystem();
            $filesystempic->copy($filePathMobilePhoto."//temp".$fileNamePhoto , $uploads_directoryPic."/"."$fileNamePhoto");
           // $filesystempic->copy($filePathMobilePhoto,$uploads_directoryPic);
            $hbr->setImage("http://127.0.0.1:8000/uploads/".$Request->get('im'));
          //  $hbr->setPrix($Request->get('pr'));
          $hbr->setPrix(0);
            $hid=$Request->get('hid');
          //  $hbr>setHebergement($this->getDoctrine()->getRepository(Hebergement::class)->find(1));
            $hbr->setHebergement($this->getDoctrine()->getRepository(Hebergement::class)->find($hid));

            $entityManager->persist($hbr);
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/jst/{transportId}", name="rdkjens")
     */
    public function updatejsontbs($transportId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer )
    {
        
        $hbr = $this->getDoctrine()->getRepository(Transport::class)->find($transportId);
        

        $hbr->setType($Request->get('type'));
        $hbr->setDisponibilite($Request->get('dis'));
        $hbr->setDescription($Request->get('desc'));
        //$hbr->setAdresse($Request->get('ad'));y
        $fileNamePhoto=$Request->get('im');
        $filePathMobilePhoto="file://C://Users//Ghiloufi//AppData//Local//Temp";
       // $filePathMobilePhoto=$Request->get('image');
        $uploads_directoryPic = $this->getParameter('images_directory');
        $filesystempic = new Filesystem();
        $filesystempic->copy($filePathMobilePhoto."//temp".$fileNamePhoto , $uploads_directoryPic."/"."$fileNamePhoto");
       // $filesystempic->copy($filePathMobilePhoto,$uploads_directoryPic);
        $hbr->setImage("http://127.0.0.1:8000/uploads/".$Request->get('im'));
        $hbr->setPrix(0);
        $hid=$Request->get('hid');
        $hbr->setHebergement($this->getDoctrine()->getRepository(Hebergement::class)->find($hid));

            $entityManager->flush();
           

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }



    /**
     * @Route("/dtr/{transportId}", name="dtr")
     */
    public function deletejsonhbr($transportId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $hbr = $this->getDoctrine()->getRepository(Transport::class)->find($transportId);
        

        $entityManager->remove($hbr);
        $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response("deleted".json_encode($jsonContent));
    }



    /**
     * @Route("/Alltr", name="oplmbhbhbjsk")
     */

    public function Alltr(NormalizerInterface $Normalizer){
        $h = $this->getDoctrine()->getRepository(Transport::class)->findAll();
        $jsonContent= $Normalizer->normalize($h,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));

     }
    
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
