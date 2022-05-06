<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Form\HebergementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;



/**
 * @Route("/hebergement")
 */
class HebergementController extends AbstractController
{


    /**
     * @Route("/newJsonhbr/new", name="newJsonhbr")
     */
    public function newJsonres(Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $hbr = new Hebergement();
        

            $hbr->setType($Request->get('type'));
            $hbr->setDisponibilite($Request->get('dis'));
            $hbr->setDescription($Request->get('desc'));
            $hbr->setAdresse($Request->get('ad'));
            $hbr->setImage($Request->get('im'));
            $hbr->setPrix($Request->get('pr'));
        
            $entityManager->persist($hbr);
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updatejsonhbr/{hebergementId}", name="updatejsonhbr")
     */
    public function updatejsonhbr($hebergementId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $hbr = $this->getDoctrine()->getRepository(Hebergement::class)->find($hebergementId);
        

            $hbr->setType($Request->get('type'));
            $hbr->setDisponibilite($Request->get('dis'));
            $hbr->setDescription($Request->get('desc'));
            $hbr->setAdresse($Request->get('ad'));
            $hbr->setImage($Request->get('im'));
            $hbr->setPrix($Request->get('pr'));
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deletejsonhbr/{hebergementId}", name="deletejsonhbr")
     */
    public function deletejsonhbr($hebergementId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $hbr = $this->getDoctrine()->getRepository(Hebergement::class)->find($hebergementId);
        

        $entityManager->remove($hbr);
        $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($hbr,'json' ,['groups' =>'post:read' ] );
        return new Response("deleted".json_encode($jsonContent));
    }



    /**
     * @Route("/Jsonhbr/{hebergementId}", name="json_hbr")
     */
    public function Jsonres($hebergementId, Request $Request, NormalizerInterface $Normalizer){
        
        //$em->this->getDoctrine()->getManager();
        $h =   $this->getDoctrine()->getRepository(Hebergement::class)->find($hebergementId);
        $jsonContent= $Normalizer->normalize($h,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));


     }

    /**
     * @Route("/Allhbr", name="Allhbr")
     */

    public function AllRes(NormalizerInterface $Normalizer){
        $h =   $this->getDoctrine()->getRepository(Hebergement::class)->findAll();
        $jsonContent= $Normalizer->normalize($h,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));



     }
    /**
     * @Route("/", name="app_hebergement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $hebergements = $entityManager
            ->getRepository(Hebergement::class)
            ->findAll();

        return $this->render('hebergement/index.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    /**
     * @Route("/hotels", name="hotels", methods={"GET"})
     */
    public function hotels(EntityManagerInterface $entityManager,Request $request, PaginatorInterface $paginator): Response
    {
        $hebergements = $entityManager
            ->getRepository(Hebergement::class)
            ->findAll();

        $hebergements = $paginator->paginate(
                $hebergements,
    
                $request->query->getInt('page', 1),
                3
                // Items per page
    
            );    

        return $this->render('hebergement/afficher.html.twig', [
            'hebergements' => $hebergements,
        ]);
    }

    /**
     * @Route("/new", name="app_hebergement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hebergement = new Hebergement();
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $hebergement->setImage($fileName);
            $entityManager->persist($hebergement);
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/new.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hebergementId}", name="app_hebergement_show", methods={"GET"})
     */
    public function show(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/show.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/consulter/{hebergementId}", name="consulter", methods={"GET"})
     */
    public function consulter(Hebergement $hebergement): Response
    {
        return $this->render('hebergement/consulter.html.twig', [
            'hebergement' => $hebergement,
        ]);
    }

    /**
     * @Route("/{hebergementId}/edit", name="app_hebergement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HebergementType::class, $hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $hebergement->setImage($fileName);
            
            $entityManager->flush();

            return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hebergement/edit.html.twig', [
            'hebergement' => $hebergement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{hebergementId}", name="app_hebergement_delete", methods={"POST"})
     */
    public function delete(Request $request, Hebergement $hebergement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hebergement->getHebergementId(), $request->request->get('_token'))) {
            $entityManager->remove($hebergement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hebergement_index', [], Response::HTTP_SEE_OTHER);
    }
}
