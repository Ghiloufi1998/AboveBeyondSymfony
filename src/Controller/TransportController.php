<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Entity\Hebergement;

use App\Form\TransportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


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
            $hbr->setImage($Request->get('im'));
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
        $hbr->setImage($Request->get('im'));
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
    public function index(EntityManagerInterface $entityManager): Response
    {
        $transports = $entityManager
            ->getRepository(Transport::class)
            ->findAll();

        return $this->render('transport/index.html.twig', [
            'transports' => $transports,
        ]);
    }

    /**
     * @Route("/new", name="app_transport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
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
            'form' => $form->createView(),
        ]);
    }

   

    /**
     * @Route("/{transportId}", name="app_transport_show", methods={"GET"})
     */
    public function show(Transport $transport): Response
    {
        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    /**
     * @Route("/{transportId}/edit", name="app_transport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
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
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{transportId}", name="app_transport_delete", methods={"POST"})
     */
    public function delete(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getTransportId(), $request->request->get('_token'))) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transport_index', [], Response::HTTP_SEE_OTHER);
    }
}
