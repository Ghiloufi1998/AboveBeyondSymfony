<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vol;
use App\Form\VolType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/vol")
 */
class VolController extends AbstractController
{
    
    /**
     * @Route("/destination", name="Alldestination")
     */
    public function getdestination( EntityManagerInterface $entityManager ,NormalizerInterface $normalizer)
    {
        $Vol = $entityManager
        ->getRepository(Reservation::class)
        ->Destination();
        $jsonContent=$normalizer->normalize($Vol,'json',['groups'=>'post:read']);
        
        
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/getVoljson", name="AllVol")
     */
    public function getVol( EntityManagerInterface $entityManager ,NormalizerInterface $normalizer)
    {
        $Vol = $entityManager
        ->getRepository(Vol::class)
        ->findAll();
        $jsonContent=$normalizer->normalize($Vol,'json',['groups'=>'post:read']);
        
        
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/AllVol/new", name="NewVol")
     */
    public function AddReservation( Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $Vol = new Vol();
        $Vol->setY($request->get("Y"));
        $Vol->setX($request->get("X"));
        $Vol->setPrix($request->get("Prix"));
        $Vol->setDestination($request->get("destination"));
        $Vol->setDepart($request->get("Depart"));
        $Vol->setImage($request->get("Image"));
        $entityManager->persist($Vol);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($Vol,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response(json_encode($jsonContent));


    }
     /**
     * @Route("/AllVol/Update/{id}", name="UpdateVol")
     */
    public function UpVol($id, Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $Vol = $entityManager
        ->getRepository(Vol::class)
        ->find($id);
        $Vol->setY($request->get("Y"));
        $Vol->setX($request->get("X"));
        $Vol->setPrix($request->get("Prix"));
        $Vol->setDestination($request->get("destination"));
        $Vol->setDepart($request->get("Depart"));
        $Vol->setImage($request->get("Image"));
        $entityManager->persist($Vol);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($Vol,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response("Modification".json_encode($jsonContent));


    }
    /**
     * @Route("/AllVol/Del/{id}", name="delVol")
     */
    public function DelVol($id, Request $request,NormalizerInterface $normalizer,EntityManagerInterface $entityManager )
    {
        $Vol = $entityManager
        ->getRepository(Vol::class)
        ->find($id);
        $entityManager->remove($Vol);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($Vol,'json',['groups'=>'post:read']);
        
       /* return $this->render('facture/Allstudents.html.twig', [
            'data' => $jsonContent,
        ]);*/
        return new Response("supprimer".json_encode($jsonContent));


    }
    /**
     * @Route("/", name="app_vol_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {    $vol=new Vol();
        
        $vols = $entityManager
            ->getRepository(Vol::class)
            ->findAll();

        return $this->render('vol/index.html.twig', [
            'vols' => $vols,
        ]);
    }
    
    /**
     * @Route("/listvol", name="vol_list", methods={"GET"})
     */
     public function listV (EntityManagerInterface $entityManager): Response
     
    {
        $pdfOptions = new Options ();
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $vols = $entityManager->getRepository(Vol::class)->findAll();
       
        //Retrieve the HTML generated in our twig flle
        $html =$this->renderView('vol/listvol.html.twig', [
            'vols' => $vols,
         ]);
    
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or
        $dompdf->setPaper('A4', 'portrait');
        // Render the HIML as PDF
         $dompdf->render ();
        //Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
        "Attachment" => true
        ]);
        
      
    }


    /**
     * @Route("/new", name="app_vol_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vol = new Vol();
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/new.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{volId}", name="app_vol_show", methods={"GET"})
     */
    public function show(Vol $vol): Response
    {
        return $this->render('vol/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    /**
     * @Route("/{volId}/edit", name="app_vol_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vol/edit.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{volId}", name="app_vol_delete", methods={"POST"})
     */
    public function delete(Request $request, Vol $vol, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getVolId(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vol_index', [], Response::HTTP_SEE_OTHER);
    }
}
