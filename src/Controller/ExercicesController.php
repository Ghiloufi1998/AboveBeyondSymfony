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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Flasher\Noty\Prime\NotyFactory;
use Flasher\Notyf\Prime\NotyfFactory;
use Flasher\Pnotify\Prime\PnotifyFactory;
use Flasher\Prime\FlasherInterface;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Flasher\Toastr\Prime\ToastrFactory;
use blackknight467\StarRatingBundle\Form\RatingType;
use Dompdf\Dompdf;
use Dompdf\Options;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
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
    public function consulter(EntityManagerInterface $entityManager,$idCrs,SessionInterface $session): Response
    {
       
        $note=$session->get('note');
        $rate=$session->get('rating');
      
        
        $exercices = $entityManager
            ->getRepository(Exercices::class)
            ->findByIdCrs($idCrs);

        return $this->render('exercices/consulterbycours.html.twig', [
            'exercices' => $exercices,
            'note' => $note,
            'rate' => $rate,
            'idCrs' => $idCrs,
        ]);
    }
     /**
     * @Route("/showc/{idCrs}", name="exerciceidc", methods={"GET"})
     */
    public function consulterhe(EntityManagerInterface $entityManager,$idCrs): Response
    {
        
        $exercices = $entityManager
            ->getRepository(Exercices::class)
            ->findByIdCrs($idCrs);

        return $this->render('exercices/exercicesbyidc.html.twig', [
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
    public function showAction($idEx,Request $request,EntityManagerInterface $entityManager,SessionInterface $session,FlasherInterface $flasher,
    ToastrFactory $toastrFactory)
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
             ->add('rating', RatingType::class, [
    	    'label' => 'Rating' ])
             ;
            
           } else {
            $builder ->add('Question'.$exercice->getIdEx(), TextareaType::class,[
                'label'=>$exercice->getQuestion(),
                

            ]);
        }


        $form = $builder->getForm();
        $form->handleRequest($request);
        $rate=$form["rating"]->getData();
        $hint=$exercice->getHint();
        $session->set('hint', $hint);
        
        $note=$session->get('note');
      
        if ($form->isSubmitted() && $form->isValid()) {
           
                $data=$form->getData();
                if ($data['Question'.$exercice->getIdEx()] === $exercice->getReponse()){
                    $note2=$note+50;
                    $session->set('note', $note2);
                    $session->set('rating', $rate);
                    $toastrFactory->addSuccess('Bravo ! Vous Avez Obtenu +50 Points');
                }else {
                    $note3=$note-20;
                    $session->set('note', $note3);
                    $session->set('rating', 0);
                    $toastrFactory->addError('Ressayer ! Vous Avez Perdu -20 Points');
 
                }
        }
        return $this->render('exercices/exercicetake.html.twig', array(
            
            'exercice' => $exercice,
            'form' => $form->createView(),
            'note' => $note,
            'rate' => $rate,
            'hint' => $hint
        ));
    }
   /**
     * @Route("/certifpdf/{idCrs}/pdf", name="certif", methods={"GET","POST"})
     */
    public function certifpdf(SessionInterface $session,EntityManagerInterface $entityManager,$idCrs)
    {
        $note=$session->get('note');
    
        $pdfOptions = new Options();
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $contxt = stream_context_create([ 
            'ssl' => [ 
                'verify_peer' => FALSE, 
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ] 
        ]);
        $dompdf->setHttpContext($contxt);
        $html = $this->renderView('exercices/certifpdf.html.twig', [
            'note' => $note,
            'idCrs' => $idCrs,
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('legal', 'landscape');
        $dompdf->render();
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false,
            
        ]);
    }
   /**
     * @Route("/bot/message", name="message")
     */
    function messageAction(Request $request,SessionInterface $session)
    {
       
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        
        $config = [];

        
        $botman = BotManFactory::create($config);

        
        $botman->hears('(Bonjour|Salut|Bonsoir|slt)', function (BotMan $bot) {
            $bot->reply('Bonjour !');
        });
        $botman->hears('(aide|help|hint)', function (BotMan $bot) {
            $hint=$session->get('hint');
            $bot->say('Ma indice pour ce exercie est : '.$hint);
        });

      
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Désole, Jai pas compris.');
        });

       
        $botman->listen();

        return new Response();
    }
        
   /**
     * @Route("/bot/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('exercices/chat_frame.html.twig');
    }
}
