<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Entity\Cours;
use App\Repository\CoursRepository;
use App\Repository\GuideRepository;
use App\Form\GuideType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonRespImageonse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/guide")
 */
class GuideController extends AbstractController
{
    /**
     * @Route("/AllGuide", name="AllGuide",methods={"GET"})
     */

    public function AllGuide(NormalizerInterface $Normalizer)
    {
        $repo=$this->getDoctrine()->getRepository(Guide::class);
        $guides=$repo->findAll();
        $jsonContent = $Normalizer->normalize($guides , 'json',['guides'=>'post:read']);
        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
     }
    /**
     * @Route("/", name="app_guide_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $guides = $entityManager
            ->getRepository(Guide::class)
            ->findAll();

        return $this->render('guide/index.html.twig', [
            'guides' => $guides,
        ]);
    }
    

    /**
     * @Route("/listeguide", name="listeguide", methods={"GET"})
     */
    public function guides(EntityManagerInterface $entityManager): Response
    {
        $guides = $entityManager
            ->getRepository(Guide::class)
            ->findAll();

        return $this->render('guide/listeguide.html.twig', [
            'guides' => $guides,
        ]);
    }
    
    /**
     * @Route("/new", name="app_guide_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guide = new Guide();
        $form = $this->createForm(GuideType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $guide->setImage("http://127.0.0.1:8000/uploads/" .$fileName);
            $entityManager->persist($guide);
            $entityManager->flush();

            return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guide/new.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idG}", name="app_guide_show", methods={"GET"})
     */
    public function show(Guide $guide): Response
    {
        return $this->render('guide/show.html.twig', [
            'guide' => $guide,
        ]);
    }
    


    /**
     * @Route("/{idG}/edit", name="app_guide_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Guide $guide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuideType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move ($this->getParameter('images_directory'),$fileName);
            $guide->setImage("http://127.0.0.1:8000/uploads/" .$fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guide/edit.html.twig', [
            'guide' => $guide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idG}", name="app_guide_delete", methods={"POST"})
     */
    public function delete(Request $request, Guide $guide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guide->getIdG(), $request->request->get('_token'))) {
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
