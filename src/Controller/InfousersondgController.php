<?php

namespace App\Controller;
use App\Entity\Infousersondg;
use App\Form\InfousersondgType;
use App\Repository\InfousersondgRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

 /**
     * @Route("/infousersondg", name="app_infousersondg")
     */
class InfousersondgController extends AbstractController
{
     /**
     * @Route("/", name="app_infousersondg_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('infousersondg/index.html.twig', [
            'controller_name' => 'InfousersondgController',
        ]);
    }

       /**
     * @Route("/{sondageId}/new", name="app_infousersondg_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,$sondageId): Response
    {
        $infoUser = new Infousersondg();
        $form = $this->createForm(InfousersondgType::class, $infoUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($infoUser);
            $entityManager->flush();

           // return $this->redirectToRoute('app_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('infousersondg/showFormUser.html.twig', [
            'infouser' => $infoUser,
            'form' => $form->createView(),
            'sondageId'=>$sondageId,
        ]);
    }
}
