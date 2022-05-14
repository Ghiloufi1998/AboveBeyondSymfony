<?php

namespace App\Controller;

use App\Entity\Guide;
use App\Entity\Cours;
use App\Entity\Vol;
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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/guide")
 */
class GuideController extends AbstractController
{
    /**
     * @Route("/AllGuide", name="AllGuide",methods={"GET"})
     */

    public function AllGuide(NormalizerInterface $Normalizer,SessionInterface $session)
    {
        $session->get('user');
        $repo=$this->getDoctrine()->getRepository(Guide::class);
        $guides=$repo->findAll();
        $jsonContent = $Normalizer->normalize($guides , 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
     }
     
        /**
     * @Route("/AllGuideByVol", name="AllGuideByvol",methods={"GET"})
     */

    public function AllGuidevol(NormalizerInterface $Normalizer,SessionInterface $session)
    {
        $session->get('user');
        $volid=$session->get('volid');
        $repo=$this->getDoctrine()->getRepository(Guide::class);
        $guides=$repo->findByidVol($volid);
        return $this->render('guide/listeguide.html.twig', [
            'guides' => $guides,
            'session' => $session,
        ]);
    }
     /**
     * @Route("/newGuide/new", name="newGuide")
     */
    public function newGuide(Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer,SessionInterface $session)
    {
        $session->get('user');
        $guide = new Guide();
            $guide->setTitre($Request->get('titre'));
            $guide->setPays($Request->get('Pays'));
            $guide->setLevel($Request->get('level'));
    
            $fileNamePhoto=$Request->get('image');
            $filePathMobilePhoto="file://C://Users//Ghiloufi//AppData//Local//Temp";
           // $filePathMobilePhoto=$Request->get('image');
            $uploads_directoryPic = $this->getParameter('images_directory');
            $filesystempic = new Filesystem();
            $filesystempic->copy($filePathMobilePhoto."//temp".$fileNamePhoto , $uploads_directoryPic."/"."$fileNamePhoto");
           // $filesystempic->copy($filePathMobilePhoto,$uploads_directoryPic);
            $guide->setImage("http://127.0.0.1:8000/uploads/".$Request->get('image'));
            $guide->setIdVol($this->getDoctrine()->getRepository(Vol::class)->find($Request->get('idvol')));
            $entityManager->persist($guide);
            $entityManager->flush();


       $jsonContent= $Normalizer->normalize($guide,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

     /**
     * @Route("/updateGuide/{idG}", name="updateGuide")
     */
    public function updateGuide($idG,Request $Request,SessionInterface $session, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $session->get('user');
        $guide = $this->getDoctrine()->getRepository(Guide::class)->find($idG);
        

        $guide->setTitre($Request->get('titre'));
        $guide->setPays($Request->get('Pays'));
        $guide->setLevel($Request->get('level'));
        $fileNamePhoto=$Request->get('image');
        $filePathMobilePhoto="file://C://Users//Ghiloufi//AppData//Local//Temp";
       // $filePathMobilePhoto=$Request->get('image');
        $uploads_directoryPic = $this->getParameter('images_directory');
        $filesystempic = new Filesystem();
        $filesystempic->copy($filePathMobilePhoto."//temp".$fileNamePhoto , $uploads_directoryPic."/"."$fileNamePhoto");
       // $filesystempic->copy($filePathMobilePhoto,$uploads_directoryPic);
        $guide->setImage("http://127.0.0.1:8000/uploads/".$Request->get('image'));
        $guide->setIdVol($this->getDoctrine()->getRepository(Vol::class)->find($Request->get('idvol')));
        
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($guide,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }
     /**
     * @Route("/deleteGuide/{idG}", name="deleteGuide")
     */
    public function deleteGuide($idG,Request $Request,SessionInterface $session, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $session->get('user');
        $guide = $this->getDoctrine()->getRepository(Guide::class)->find($idG);
        

        $entityManager->remove($guide);
        $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($guide,'json' ,['groups' =>'post:read' ] );
        return new Response("deleted".json_encode($jsonContent));
    }

    /**
     * @Route("/", name="app_guide_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $guides = $entityManager
            ->getRepository(Guide::class)
            ->findAll();

        return $this->render('guide/index.html.twig', [
            'guides' => $guides,
            'session' => $session,
        ]);
    }
       

    /**
     * @Route("/listeguide", name="listeguide", methods={"GET"})
     */
    public function guides(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        $guides = $entityManager
            ->getRepository(Guide::class)
            ->findAll();

        return $this->render('guide/listeguide.html.twig', [
            'guides' => $guides,
            'session' => $session,
        ]);
    }
    
    /**
     * @Route("/new", name="app_guide_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idG}", name="app_guide_show", methods={"GET"})
     */
    public function show(Guide $guide,SessionInterface $session): Response
    {
        $session->get('user');
        return $this->render('guide/show.html.twig', [
            'guide' => $guide,
            'session' => $session,
        ]);
    }
    


    /**
     * @Route("/{idG}/edit", name="app_guide_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Guide $guide, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
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
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idG}", name="app_guide_delete", methods={"POST"})
     */
    public function delete(Request $request, Guide $guide, EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $session->get('user');
        if ($this->isCsrfTokenValid('delete'.$guide->getIdG(), $request->request->get('_token'))) {
            $entityManager->remove($guide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guide_index', [], Response::HTTP_SEE_OTHER);
    }
}
