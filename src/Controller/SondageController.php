<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Questions;
use App\Entity\Reponses;
use App\Form\SondageType;
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
use Symfony\Component\Validator\Constraints as Assert; 
use Gregwar\CaptchaBundle\Type\CaptchaType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * 
    * @Route("/", name="app_sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $RepositorySondage): Response
    {
        $sondages = $RepositorySondage ->findAll();

        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages,
        ]);
    }


     /**
     * @Route("/list", name="app_sondage_user", methods={"GET"})
     */
    public function ListSondageUser(SondageRepository $RepositorySondage): Response
    {
        $sondages = $RepositorySondage ->findAll();

        return $this->render('sondage/ListSondageUser.html.twig', [
            'sondages' => $sondages,
        ]);
    }

    
     /**
     * @Route("/stat", name="app_sondage_stat")
     */
    public function statistique(SondageRepository $repo, ReponsesRepository $rep): Response
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
        
         
      return $this->render('reponses/showRepStat.html.twig',[
          'sondNom'=> json_encode($sondNom),
          'repCount'=> json_encode($repCount),
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
                            $repText[]= $rep->findByText($questionId);
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
       
        //dd($data);
    
    }


     /**
     * @Route("/{sondageId}/showsurvey", name="app_sondage_showsurvey", methods={"GET","POST"})
     */
    public function showAction($sondageId,Request $request)
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

      public function exportToExcel($sondageId,SondageRepository $srepo,QuestionsRepository $repo, ReponsesRepository $rep ):Response
      {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setTitle("My First Worksheet");
        
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // In this case, we want to write the file in the public directory
       // $publicDirectory = $this->get('kernel')->getProjectDir() . '/public';
        // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
        $excelFilepath =  'C:\Users\user\Desktop\my_first_excel_symfony4.xlsx';
        
        // Create the file
        $writer->save($excelFilepath);
        
        // Return a text response to the browser saying that the excel was succesfully created
        return new Response("Excel generated succesfully");
      }
  
}
