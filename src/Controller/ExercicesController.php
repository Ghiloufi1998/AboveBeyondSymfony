<?php

namespace App\Controller;

use App\Entity\Exercices;
use App\Entity\Cours;
use App\Form\ExercicesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * @Route("/exercices")
 */
class ExercicesController extends AbstractController
{
    /**
     * @Route("/", name="app_exercices_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercices::class)
            ->findAll();

        return $this->render('exercices/index.html.twig', [
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/new", name="app_exercices_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercices();
        $form = $this->createForm(ExercicesType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $exercice->setImage($fileName);
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercices/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEx}", name="app_exercices_show", methods={"GET"})
     */
    public function show(Exercices $exercice): Response
    {
        return $this->render('exercices/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }
    /**
     * @Route("/consulter/exercices/{idCrs}", name="exercicebyidc", methods={"GET"})
     */
    public function consulter(EntityManagerInterface $entityManager,$idCrs): Response
    {
        $exercices = $entityManager
            ->getRepository(Exercices::class)
            ->findByIdCrs($idCrs);

        return $this->render('exercices/consulterbycours.html.twig', [
            'exercices' => $exercices,
        ]);
    }
    /**
     * @Route("/take/{idEx}/take", name="exercicetake", methods={"GET", "POST"})
     */
    public function take(Request $request, Exercices $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExercicesType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $exercice->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercices/exercicetake.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{idEx}/edit", name="app_exercices_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Exercices $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExercicesType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $fileName=(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('kernel.project_dir').'/public/uploads', $fileName);
            $exercice->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercices_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercices/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEx}", name="app_exercices_delete", methods={"POST"})
     */
    public function delete(Request $request, Exercices $exercice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercice->getIdEx(), $request->request->get('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercices_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/take/{idEx}/take", name="exercicetake", methods={"GET", "POST"})
     */
    public function showAction($idEx,Request $request,EntityManagerInterface $entityManager)
    {
        $em = $this->getDoctrine()->getManager();

        $exercice = $entityManager
        ->getRepository(Exercices::class)
        ->find($idEx);
        $form = $this->createForm(ExercicesType::class, $exercice);
       

        $builder = $this->createFormBuilder();

           $type=$exercice->getType();
            if ($type == 'QCM' ){
            $builder->add('Question'.$exercice->getIdEx(),  ChoiceType::class,[
                'expanded' => true,
                'label' => $exercice->getQuestion(),
                'choices' => [
                    'Oui'=>"Oui",
                    'Non' =>"Non",
                ],
                'attr'=>[
                    'style'=> 'margin:15px; display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                ]
             ]) 
             ;
            
           } else {
            $builder ->add('Question'.$exercice->getIdEx(), TextareaType::class,[
                'label'=>$exercice->getQuestion(),
                

            ]);
        }

               
             
              
        

        $form = $builder->getForm();
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()) {
           
                $data=$form->getData();
                if ($data['Question'.$exercice->getIdEx()] === $exercice->getReponse()){
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Bravo ! +50 points'
                    );
                }else {
                    $this->get('session')->getFlashBag()->add(
                        'notice',
                        'Ressayer stp ! -50 points'
                    );

                }
                
               
        
            


        }

        return $this->render('exercices/exercicetake.html.twig', array(
            'entity' => $exercice,
            'form' => $form->createView()
        ));
}
}