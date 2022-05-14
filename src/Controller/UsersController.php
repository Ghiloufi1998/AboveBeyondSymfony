<?php

namespace App\Controller;
use App\Entity\Admin;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Form\UserType;
use App\Form\LoginType;
use App\Repository\UserRepository;
use App\Repository\UsersRepository;

use App\Form\RecuperermotdepasseType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\Serializer\Serializer;


use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;



class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(SessionInterface $session): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'session'=>$session,

        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function inscrit(Request $request ,\Swift_Mailer $mailer)
    {
        $User = new User();
        $form=$this->createForm(UserType::Class,$User);
        $form->add('Register', SubmitType::class);

        $form->handleRequest($request);

       if ($form->isSubmitted()&& $form->isValid()){
           //$User=$form->getData();
           $file=$form->get('image')->getData();
           $fileName=(uniqid()).'.'.$file->guessExtension();
           $file->move($this->getParameter('upload_directory'), $fileName);
           $User->setImage($fileName);
           $em=$this->getDoctrine()->getManager();
           $em->persist($User);
           $em->flush();
           $message = (new \Swift_Message('User'))
                ->setFrom('pidevarcane@gmail.com')
                ->setTo($User->getEmail())
                ->setBody("Bienvenue à Arcane Travel Agency");
            $mailer->send($message) ;
           return $this->redirectToRoute('login');
        }
        return $this->render('users/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/pdfuser", name="PDFuser", methods={"GET"})
     */
    public function pdf(UserRepository $UserRepository,SessionInterface $session): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('users/pdfusers.html.twig', [
            'users' => $UserRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
 /**
     * @Route("/listUser", name="listUser")
     */
    public function listUser(Request $request , PaginatorInterface $paginator,SessionInterface $session,UserRepository $repository ): Response

   {
    $repository=$this->getDoctrine()->getRepository(User::Class);
    $Users=$repository->findAll();
    $users = $paginator->paginate(
        $Users,
        $request->query->getInt('page',1),
       
    );
    $male=$repository->findMale();
    $female=$this->getDoctrine()->getRepository(User::Class)->findFemale();



    return $this->render('users/listusers.html.twig', [
        'Users' => $users,
        "session"=>$session,
        'male'=>$male,
        'female'=>$female,
    ]);
    
    }
    
    /**
     * @Route("/listadmin", name="listUser2")
     */
    public function listUser2(Request $request , PaginatorInterface $paginator,SessionInterface $session ): Response

   {
    $repository=$this->getDoctrine()->getRepository(User::Class);
    $Users=$repository->findAll();
    $users = $paginator->paginate(
        $Users,
        $request->query->getInt('page',1),
        5

    );

    return $this->render('users/listusers.html.twig', [
        
        'Users' => $users,
        "session"=>$session,
    ]);
    
    }
 /**
     * @Route("/Userlist", name="Userlist")
     */
    public function Userlist(Request $request , PaginatorInterface $paginator,SessionInterface $session ): Response

   {
    $repository=$this->getDoctrine()->getRepository(User::Class);
    $Users=$repository->findAll();
    $users = $paginator->paginate(
        $Users,
        $request->query->getInt('page',1),
       3
    );

    return $this->render('users/userslist.html.twig', [
        
        'Users' => $users,
        "session"=>$session,
    ]);
    
    }


    /**
     * @Route("/updateUser/{id}", name="updateUser")
     */
    public function updateUser(Request $request, $id,SessionInterface $session)
    {
        $em=$this->getDoctrine()->getManager();
        $User = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $User);
        
        $form->add('Modifier',SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('listUser');
        }

        return $this->render('users/updateUser.html.twig', [
                        'form' => $form->createView(),
                    "session"=>$session,
        ]);
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     */
    public function deleteUser($id)
    {
      
        $em=$this->getDoctrine()->getManager();
        $User = $em->getRepository(User::class)->find($id);
        $em->Remove($User);
         $em->flush();

           return $this->redirectToRoute('listUser');

    }

 /**
     * @Route("/showUser/{id}", name="showUser")
     */

    public function showUser($id,SessionInterface $session): Response
    {
        $repository=$this->getDoctrine()->getRepository(User::Class);
        $User=$repository->find($id);

        return $this->render('users/showUser.html.twig', [
            'User' => $User,
            "session"=>$session,
        ]);
}

 /**
     * @Route("/Usershow", name="Usershow")
     */

    public function Usershow(SessionInterface $session)
    {
        if($session->has('user')){
         $repository=$this->getDoctrine()->getRepository(User::Class);
         $User=$repository->find($session->get('user')->getId());

        return $this->render('users/Usershow.html.twig', [
            'session' => $session,
            'User' => $User,
        ]);
}

else{
    return $this->redirectToRoute('login');
}

    }

/**
     * @Route("/TrierParDate", name="TrierParDate")
     */
    public function TrierParDate(Request $request , PaginatorInterface $paginator,SessionInterface $session): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $Users = $repository->findByDate();
        $Users = $paginator->paginate(
            $Users,
            $request->query->getInt('page',1),4
        );
        return $this->render('users/listusers.html.twig', [
            'Users' => $Users,
            "session"=>$session,
        ]);
    }

    /**
     * @Route("/TrierParDate2", name="TrierParDate2")
     */
    public function TrierParDate2(Request $request , PaginatorInterface $paginator,SessionInterface $session): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $Users = $repository->findByDate2();
        $Users = $paginator->paginate(
            $Users,
            $request->query->getInt('page',1),4
        );
        return $this->render('users/listusers.html.twig', [
            'Users' => $Users,
            "session"=>$session,
        ]);
    }
    
  /**
     * @Route("/login", name="login")
     */
    public function login(UserRepository $userRepository , SessionInterface $session,Request $request, \Swift_Mailer $mailer): Response
    {

        $userlogin = new User();
        $connexionform=$this->createForm(LoginType::class, $userlogin);

        $connexionform->add('Login',SubmitType::class);
        $connexionform->handleRequest($request);

        $recupererform=$this->createForm(RecuperermotdepasseType::class, $userlogin);
        $recupererform->add('Reset',SubmitType::class);
        $recupererform->handleRequest($request);

        if ($recupererform->isSubmitted() && $recupererform->isValid()){
            $em=$this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(array('email'=>$userlogin->getEmail()));

            if(is_null($user)){
                return $this->redirectToRoute('login', [
                    'form' => $connexionform->createView(),
                ]);
            }
            else{
                $pwdnew=$user->getPassword()."new";
                $message = (new \Swift_Message('User reset mot de passe '))
                ->setFrom('pidevarcane@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("votre nouveau mot de passe : ".$pwdnew);
                $user->setPassword($pwdnew);
                $em->flush($user);
                $mailer->send($message) ;
                
                return $this->redirectToRoute('login', [
                  
                ]);
            }

        }

        if ($connexionform->isSubmitted()){
            $em=$this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(array('email'=>$userlogin->getEmail(),'password'=>$userlogin->getPassword()));
            $admin = $em->getRepository(Admin::class)->findOneBy(array('email'=>$userlogin->getEmail(),'password'=>$userlogin->getPassword()));
            //$user=$userRepository->findOneBy(array('email'=>$userlogin->getEmail(),'password'=>$userlogin->getPassword()));
            if(is_null($user) && is_null($admin)){
                return $this->redirectToRoute('login', [
                    'form' => $connexionform->createView(),
                    'formrec' => $recupererform->createView(),
                ]);
            }
            else if (! is_null($user) ){
                $session->set('user',$user);

                return $this->redirectToRoute('users', [
                  'session'=>$session,
                ]);
            }
            else {
                $session->set('admin',$admin);
                return $this->redirectToRoute('admin_index', [
                    'session'=>$session,
                ]);
            }
        }
        else{
            return $this->render('users/login.html.twig', [
                'form' => $connexionform->createView(),
                'formrec' => $recupererform->createView(),
                "session"=>$session,
            ]);
        }
    }
   

     /**
     * @Route("/logout", name="test_logout")
     */
    public function logout(SessionInterface $session){
        $session->remove('user');
        
        return $this->redirectToRoute('login', [
          'session'=>$session,
        ]);
    }
    //***********************************************************************************************************************************//

    /**
     * @Route("/listUserJSON", name="listUserJSON")
     */
    public function listUserJSON(Request $request , NormalizerInterface $Normalizer): Response

    {
        $repository=$this->getDoctrine()->getRepository(User::Class);
        $Users=$repository->findAll();

        $jsonContent = $Normalizer->normalize($Users,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/showUserJSON/{id}", name="showUserJSON")
     */

    public function showUserJSON($id,NormalizerInterface $Normalizer): Response
    {
        $repository=$this->getDoctrine()->getRepository(User::Class);
        $User=$repository->find($id);

        $jsonContent = $Normalizer->normalize($User,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AddJSON", name="AddJSON")
     */
    public function AddJSON(Request $request,NormalizerInterface $Normalizer, \Swift_Mailer $mailer )
    {
        $nom = $request->query->get("name");
        $prenom = $request->query->get("fname");
        $gender = $request->query->get("gender");
        $num = $request->query->get("num");
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $birthday = $request->query->get("birthday");
        //$image = $request->query->get("image");

        $em=$this->getDoctrine()->getManager();
        $User = new User();

        $User->setName($nom);
        $User->setFname($prenom);
        $User->setGender($gender);
        $User->setNum($num);
        $User->setEmail($email);
        $User->setPassword($password );
        $User->setBirthday(new \DateTime($birthday));
        //$User->setImage($image);

        $message = (new \Swift_Message('Arcane'))
            ->setFrom('pidevarcane@gmail.com')
            ->setTo($email)
            ->setBody("Bienvenue à Arcane Travel Agency");
        $mailer->send($message) ;

        $em->persist($User);
        $em->flush();
        $jsonContent = $Normalizer->normalize($User,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/UpdateJSON/{id}", name="UpdateJSON")
     */
    public function UpdateJSON(Request $request,NormalizerInterface $Normalizer,$id )
    {

        // $id = $request->get("id");
        $nom = $request->query->get("name");
        $prenom = $request->query->get("fname");
        $gender = $request->query->get("gender");
        $num = $request->query->get("num");
        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $birthday = $request->query->get("birthday");


        $em=$this->getDoctrine()->getManager();
        $User = $em->getRepository(User::class)->find($id);


        
        $User->setName($nom);
        $User->setFname($prenom);
        $User->setGender($gender);
        $User->setNum($num);
        $User->setEmail($email);
        $User->setPassword($password );
        $User->setBirthday(new \DateTime($birthday));

        $em=$this->getDoctrine()->getManager();
        $em->persist($User);
        $em->flush();
        

        $jsonContent = $Normalizer->normalize($User,'json',['groups'=>'post:read']);
        return new Response("User updated".json_encode($jsonContent));
    }

    /**
     * @Route("/RemoveJSON/{id}", name="RemoveJSON")
     */
    public function RemoveJSON(Request $request,NormalizerInterface $Normalizer,$id )
    {


        $em=$this->getDoctrine()->getManager();
        $User = $em->getRepository(User::class)->find($id);

        $em->remove($User);
        $em->flush();

        $jsonContent = $Normalizer->normalize($User,'json',['groups'=>'post:read']);
        return new Response("User deleted".json_encode($jsonContent));
    }

    /**
     * @Route("user/rechercheJSON", name="rechercheJSON")

     */
    function Recherche(UserRepository $repository,Request $request,NormalizerInterface $Normalizer){

        $data=$request->get('Search');
        $Users=$repository->findBy(['name'=>$data]);

        $jsonContent = $Normalizer->normalize($Users,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/LoginJSON", name="LoginJSON")

     */
    function LoginJSON(UserRepository $repository,Request $request,NormalizerInterface $Normalizer){

        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em=$this->getDoctrine()->getManager();
        $User=$em->getRepository(User::class)->findOneBy(['email'=>$email,'password'=>$password]);

        if ($User)
        {
            $jsonContent = $Normalizer->normalize($User,'json',['groups'=>'post:read']);
            return new Response(json_encode($jsonContent));
        }
        else {
            return new Response("failed");
        }
    }

    /**
     * @Route("/getPasswordByEmail", name="getPasswordByEmail")
     */

    public function getPassswordByEmail(Request $request) {

        $email = $request->get('email');
        $User = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['email'=>$email]);
        if($User) {
            $password = $User->getPassword();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($password);
            return new JsonResponse($formatted);
        }
        return new Response("User not found");




    }
}
