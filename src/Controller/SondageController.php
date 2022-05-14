<?php

namespace App\Controller;

use App\Entity\Infousersondg;
use App\Entity\CommentLikes;
use App\Entity\Feedback;
use App\Entity\Sondage;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Entity\SearchData;
use App\Form\SondageType;
use App\Form\FeedbackType;
use App\Form\SearchFormType;
use App\Repository\InfousersondgRepository;
use App\Repository\FeedbackRepository;
use App\Repository\SondageRepository;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints as Assert; 
use Gregwar\CaptchaBundle\Type\CaptchaType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use App\Repository\CommentLikesRepository;
use App\Form\InfousersondgType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;




/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * 
    * @Route("/", name="app_sondage_index",methods={"GET"})
     */
    public function index(SondageRepository $RepositorySondage, Request $request): Response
    {
        $sondages=$RepositorySondage->findAll();
        
 return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages
           
        ]);
    }


     /**
     * @Route("/newJsonSond/new", name="newJsonSond")
     */
    public function newJsonSond(Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $S = new Sondage ();
        

            $S->setSujet($Request->get('sjt'));
            $S->setCategorie($Request->get('cat'));
           
        
            $entityManager->persist($S);
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($S,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/updatejsons/{sondageId}", name="upsnd")
     */
    public function updatejsonsond($sondageId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $s = $this->getDoctrine()->getRepository(Sondage::class)->find($sondageId);
        

            $s->setSujet($Request->get('sjt'));
            $s->setCategorie($Request->get('cat'));
            
            $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($s,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/deletejsonsond/{sondageId}", name="deletsondageId",methods={"GET", "POST"})
     */
    public function deletejsonsond($sondageId,Request $Request, EntityManagerInterface $entityManager, NormalizerInterface $Normalizer)
    {
        $s = $this->getDoctrine()->getRepository(Sondage::class)->find($sondageId);
        

        $entityManager->remove($s);
        $entityManager->flush();
         

       $jsonContent= $Normalizer->normalize($s,'json' ,['groups' =>'post:read' ] );
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
     * @Route("/AllSondage", name="allasond")
     */

    public function AllSondage(NormalizerInterface $Normalizer){
        $s =   $this->getDoctrine()->getRepository(Sondage::class)->findAll();
        $jsonContent= $Normalizer->normalize($s,'json' ,['groups' =>'post:read' ] );
        return new Response(json_encode($jsonContent));



     }


      /**
     * @Route("/list", name="app_sondage_user")
     */
    public function ListSondageUser(SondageRepository $RepositorySondage,Request $request,FeedbackRepository $repfeed): Response
    {    
        $sondages=$RepositorySondage->findAll();
        $comment=$repfeed->findAll();
        
      
 return $this->render('sondage/ListSondageUser.html.twig', [
            'sondages' => $sondages,
            'commentaire'=>$comment,
          // 'form_f'=>$form->createView(),
          // 'form'=>$form->createView(),
          // 'commentaire'=>$commentaire,
        ]);
    }


    
        /**
     * @Route("/comment", name="app_sondage_comment")
     */
    public function newComment(FeedbackRepository $repfeed ,CommentLikesRepository $repc ,Request $request, EntityManagerInterface $entityManager):Response
    {
        $feedbacks=$repfeed->findAll();
        $feedback = new Feedback();
        $form= $this->createForm(FeedbackType::class,$feedback);
              foreach($feedbacks as $fd){
                  if(!empty($fd)){
                   $commentaire[]=$fd->getCommentaire();
                  // $x=$feedbacks->getId();
                   //$likes=count($repc->findbyFeedback($feedbacks));
                  //// $feedbacks->setNbrLikes($likes);



                  }else{
                      $Commentaire[]="";
                  }
              
              }
             
              $form->handleRequest($request);
              if ($form->isSubmitted() && $form->isValid()) {
                  $feedback->setCreatedAT(new \DateTime());
                  $feedback->setNbrLikes(0);
                  $entityManager->persist($feedback);
                  $entityManager->flush();
      
                  return $this->redirectToRoute('app_sondage_user', ['commentaire'=>$feedbacks], Response::HTTP_SEE_OTHER);
              }
              return $this->render('sondage/feedback.html.twig', [
                'form' => $form->createView(),
                
            ]);
           
    }

    
     /**
     * @Route("/stat", name="app_sondage_stat")
     */
    public function statistique(SondageRepository $repo, ReponsesRepository $rep, InfousersondgRepository $repUser): Response
    {
        $sondages = $repo->findAll();
        foreach($sondages as $sondage){
        $sondNom[]= $sondage->getSujet();
        $question[]=$sondage->getQuestion();
       // dd($question);
        // dd($sondNom);

         foreach($sondage->getQuestion() as $qst){
            $qstId=$qst->getQuestionId();
            $reponse=$rep->findByQstId($qstId);
            $repCount[]=count($reponse);
        
     } 
        $nbrQst[]=count($sondage->getQuestion());
       // $nbrRep[]=($repCount/$nbrQst);
     }

     //Stat par age 

     $userInfo = $repUser->findAll();
     foreach($userInfo as $info){
     $ageUser[]= $info->getAge();
     $sexeUser[]=$info->getSexe();
     $payUser[]=$info->getPay();
      

     foreach($ageUser as $age){
         
         
            $Age=$repUser->findByAge($age);
            $nbrAge[]=count($Age);
            $ageU[]=$age;
        
       
    }

    $age_uni = array_unique($ageU);
           

    foreach($sexeUser as $sexe){
        if ($sexe==="Femme"){
            $Femme=$repUser->findByFemme($sexe);
            $nbrFemme=count($Femme);
          //  $payU[]=$pay;
        }else if($sexe==="Homme"){
            $Homme=$repUser->findByHomme();
            $nbrHomme=count($Homme);
        }
       
        }

        foreach($payUser as $pay){
                 
            $Pay=$repUser->findByPay($pay);
            $nbrPay[]=count($Pay);
            $payU[]=$pay;
        
       
    }

    $pay_uni = array_unique($payU);
    
    
    //dd($nbrFemme,$nbrHomme);
} 
return $this->render('reponses/showRepStat.html.twig',[
          'sondNom'=> json_encode($sondNom),
          'repCount'=> json_encode($repCount),
          'nbrPay'=>json_encode($nbrPay),
          'pay_uni'=>json_encode($pay_uni),
          'nbrHomme'=>json_encode($nbrHomme),
          'nbrFemme'=>json_encode($nbrFemme),
          'nbrAge'=>json_encode($nbrAge),
          'ageUser'=>json_encode($age_uni),
          'sondages' => $sondages
          
        
      ]);
    }  

    
    



    /**
     * @Route("/new", name="app_sondage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    
     


    /**
     * @Route("/{sondageId}", name="app_sondage_show", methods={"GET"})
     */
  /*  public function show(Sondage $sondage): Response
    {
        return $this->render('questions/index.html.twig', [
            'sondage' => $sondage,
        ]);
    }*/


     /**
     * @Route("/{sondageId}/new", name="app_infousersondg_new", methods={"GET", "POST"})
     */
    public function newinfouser(Request $request, EntityManagerInterface $entityManager,$sondageId): Response
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

    /**
     * @Route("/{sondageId}/edit", name="app_sondage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sondage $sondage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/like", name="kkk", methods={"GET", "POST"})
     */
    public function like(Request $request,SondageRepository  $rs , $id ,FeedbackRepository $repfeed ,CommentLikesRepository $repc , EntityManagerInterface $entityManager ,FlashyNotifier $flashy): Response
    {
        $sondages=$rs->findAll();
        $comment=$repfeed->findAll();

       $c=new CommentLikes();
      $f= $repfeed->find($id);
            $c->setFeedback($f);
            $entityManager->persist($c);
            $entityManager->flush();
            $flashy->success('Merci pour liker!');
            
            $f->setNbrLikes(($f->getNbrLikes())+1);
            $entityManager->flush();

         
        return $this->render('Sondage/ListSondageUser.html.twig',
    ['sondages'=>$sondages,'commentaire'=>$comment]);
    }

    /**
     * @Route("/{sondageId}", name="app_sondage_delete", methods={"POST"})
     */
    public function delete(Request $request, Sondage $sondage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getSondageId(), $request->request->get('_token'))) {
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sondage_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/stat/{sondageId}/{questionId}", defaults={"questionId" = 0 },name="app_reponses_stat")
     */
    public function repStatic (SondageRepository $srepo,QuestionsRepository $repo, ReponsesRepository $rep, $sondageId,$questionId): Response
    {
        $questions = $repo->findById($sondageId);
        $sondage=$srepo->find($sondageId);
        if ($questionId===0){
            return $this->render('reponses/showReponse.html.twig', [
                'questions' => $questions,
                'questionId'=>$questionId
            ]);
          
                   }else{
                    $qst=$repo->find($questionId);
        
                    //   dd($qst);
                      
                      $type=$qst->getType();
                      $question=$qst->getQuestion();
                       if ($type === "YES/NO"){
                          
                           $nbrYes=count($rep->findByYes($questionId));
                           $nbrNon=count($rep->findByNo($questionId));
                           return $this->render('reponses/showReponse.html.twig', [
                            'questions' => $questions,
                            'nbrYes' =>json_encode($nbrYes),
                            'nbrNon' =>json_encode($nbrNon),
                            'question'=>json_encode($question),
                            'questionId'=>$questionId,
                            'type'=>$type
                        ]);

                        }else if ($type === "Text"){
                            $repText= $rep->findByText($questionId);
                            return $this->render('reponses/showReponse.html.twig', [
                                'questions' => $questions,
                                'repText'=>$repText,
                                'question'=>$question,
                                'questionId'=>$questionId,
                                'type'=>$type
                            ]);
                   }else if ($type === "Rate"){
                    $star1=count($rep->findByStar1($questionId));
                    $star2=count($rep->findByStar2($questionId));
                    $star3=count($rep->findByStar3($questionId));
                    $star4=count($rep->findByStar4($questionId));
                    $star5=count($rep->findByStar5($questionId));
                    return $this->render('reponses/showReponse.html.twig', [
                        'questions' => $questions,
                        'star1'=>json_encode($star1),
                        'star2'=>json_encode($star2),
                        'star3'=>json_encode($star3),
                        'star4'=>json_encode($star4),
                        'star5'=>json_encode($star5),
                        'question'=>json_encode($question),
                        'questionId'=>$questionId,
                        'type'=>$type
                    ]);
           
                   }
        }
       
        //stat sexe par sondage


    
    }


     /**
     * @Route("/{sondageId}/showsurvey", name="app_sondage_showsurvey", methods={"GET","POST"})
     */
    public function showAction($sondageId,Request $request,FlashyNotifier $flashy)
    {
        $em = $this->getDoctrine()->getManager();

        
        $entity = $em->getRepository(Sondage::class)->find($sondageId);
        $builder = $this->createFormBuilder();
        foreach ($entity->getQuestion() as $question) {
           $type=$question->getType();
            if ($type==='YES/NO' ){
           
            $builder->add('question'.$question->getQuestionId(), ChoiceType::class,[
                'expanded' => true,
                'label' => $question->getQuestion(),
            
                'choices' => [
                    'Yes'=>"Yes",
                    'No' =>"No",
                ],
                'attr'=>[
                    'style'=>'display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                   
                ]
             ]) 
             ;
            
           } elseif ($type ==='Text'){
                $builder ->add('question'.$question->getQuestionId(), TextareaType::class,[
                    'label'=>$question->getQuestion(),
                    
                    

                ]);
             }else {//($type ==='Rate'){
                $builder ->add('question'.$question->getQuestionId(),  ChoiceType::class ,[
                    'expanded' => true,
                    'label' => $question->getQuestion(),
                    'choices' => [
                        'One'=>"1",
                        'Two' =>"2",
                        'Three' =>"3",
                        'Four' =>"4",
                        'Five' =>"5",
                    ],
                    'attr'=>[
                        'style'=>'display : flex; flex-direction: row-reverse; align-items: flex-start; justify-content : center; ',
                    ]
                 ]) 
                 ;}
                    

               
             }

             $builder->add('captcha', CaptchaType::class);
           
              
        

        $form = $builder->getForm();
        $form->handleRequest($request);
        $reponse=new Reponses();
        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($entity->getQuestion() as $question) {
                $data=$form->getData();
                $reponse=new Reponses();
               // $dataRep=$data['question'.$question->getQuestionId()];
               $reponse->setReponse($data['question'.$question->getQuestionId()]);
                $reponse->setQuestion($question);
                $em->persist($reponse);
                $em->flush();
                $flashy->success('Réponse envoyé!');
                
               
            }
            
            return $this->redirectToRoute('app_sondage_user', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('sondage/SubmitSondage.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView()
        ));
    }

     /**
     * @Route("/excel/{sondageId}", name="app_sondage_excel")
     */

      public function exportToExcel($sondageId,SondageRepository $srepo,QuestionsRepository $repo, ReponsesRepository $rep,FlashyNotifier $flashy ):Response
      {
        $questions = $repo->findById($sondageId);
        $sondage=$srepo->find($sondageId);
        $spreadsheet = new Spreadsheet();
        $worksheet = new Worksheet();
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing();
        $drawing->setName('PhpSpreadsheet logo');
       $drawing->setPath('./uploads/logo.png');
       $drawing->setHeight(20);
        $spreadsheet->getActiveSheet()->getHeaderFooter()->addImage($drawing, \PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter::IMAGE_HEADER_LEFT);
        $spreadsheet->getActiveSheet()->setBreak('A1', \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::BREAK_COLUMN);
      
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A2', 'Suivis des Réponses !');
        $sheet->setCellValue('A3', 'Sujet ');
        $sheet->setCellValue('B3', $sondage->getSujet());
        $sheet->setCellValue('A4', 'Catégorie');
        $sheet->setCellValue('B4', $sondage->getCategorie());

        $sheet->setTitle("My First Worksheet");
               // ARRAYY 
       
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // In this case, we want to write the file in the public directory
       // $publicDirectory = $this->get('kernel')->getProjectDir() . '/public';
        // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
        $excelFilepath =  'C:\Users\user\Desktop\my_first_excel_symfony43.xlsx';
        
        // Create the file
        $writer->save($excelFilepath);
        
        // Return a text response to the browser saying that the excel was succesfully created
        return new Response("Excel generated succesfully");

      }

    /*  public function Search (SondageRepository $srepo){
          $data=new SearchData();
          $form = $this->createForm(SearchForm::class, $data);
          
        return $this->render('sondage/ListSondageUser.html.twig', [
            'sondages' => $sondages,
            'form'=>$form->createView()
        ]);

      }*/
  
}
