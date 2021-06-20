<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Condidat;
use App\Form\ResetPasswordType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\CondidatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, CategorieRepository $categoRepository, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $categorie = $categoRepository->findAll();
        $condidat = new Condidat();
        $form = $this->createForm(RegistrationFormType::class, $condidat);
        //dd($condidat);
        $form->handleRequest($request);
        //dd($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $condidat->setCreatedAt(new \DateTime());
            $filecv = $condidat->getCvimage();
            $filepdp = $condidat->getProfileimage();
            
            $fileNamecv= md5(uniqid()).'.'.$filecv->guessExtension();
            $fileNamepdp= md5(uniqid()).'.'.$filepdp->guessExtension();
            try {
                $filecv->move(
                    $this->getParameter('ccvimage_directory'),
                    $fileNamecv
                );
                $filepdp->move(
                    $this->getParameter('cpdpimage_directory'),
                    $fileNamepdp
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $condidat->setEnabled(false);
            $condidat->setRoles(array('ROLE_CONDIDAT'));
            $condidat->setPassword(
                $passwordEncoder->encodePassword(
                    $condidat,
                    $form->get('plainPassword')->getData()
                )
            );
        
            $condidat->setToken($this->generateToken());
            $token=$condidat->getToken();
            //dd($condidat);
            $entityManager = $this->getDoctrine()->getManager();
            $condidat->setCvimage($fileNamecv);
            $condidat->setProfileimage($fileNamepdp);
            $entityManager->persist($condidat);
            $entityManager->flush();
            //$this->mailer->sendEmail($condidat->getEmail(), $condidat->getToken());
            //----------------------------------------------------------------------
            $email = (new TemplatedEmail())
        
            ->from('registration@example.com')
            ->to(new Address($condidat->getEmail()))
            ->subject('Thanks for signing up!')
        
            // path of the Twig template to render
            ->htmlTemplate('emails/signup.html.twig')
        
            // pass variables (name => value) to the template
            ->context([
                
                'token' => $token,
            ])
        ;
    
             $mailer->send($email);
            // do anything else you need here, like send an email
            return $this->redirectToRoute('index');
        }

        return $this->render('registration/register.html.twig', array(
            'registrationForm' => $form->createView(),
            'categories' => $categorie,
        ));
    }
    /**
     * @Route("/confirmermoncpt/{token}",name="confirmaccount")
     * @param string $token
     */
    public function confirmation(string $token){

     $cdd= $this->getDoctrine()->getRepository(Condidat::class)->findOneBy(["token" => $token]);
     if($cdd){
        $cdd->setToken(null);
        $cdd->setEnabled(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cdd);
        $entityManager->flush();
        $this->addFlash("success","This Account is active");
        return $this->redirectToRoute('index');
     } else{
         $this->addFlash("error","This Account isn't verified"); // // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
         return $this->redirectToRoute('index');
     }
     return $this->json($token);
    }

    /**
     * @Route("/resetpassword", name="app_resetpassword")
     */
    public function resetpassword(Request $request,CategorieRepository $categoRepository , UserRepository $userrepository ,  MailerInterface $mailer ){
        $categorie = $categoRepository->findAll();
        $form = $this->createForm(ResetPasswordType::class);
        // traitement du formulaire
        $form->handleRequest($request);
        // ken formulaire valide
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $user = $userrepository->findOneByEmail($data['email']);
            // kén utilisateur moch mawjoud
            if(!$user){
                $this->addFlash('danger','l\'utilisateur n\'existe pas');
                return $this->redirectToRoute('app_login');
            }
            // 3amek token
            $resettoken = $this->generateToken();
            $user->setResettoken($resettoken);
            $resettoken=$user->getResettoken();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $email = (new TemplatedEmail())
        
            ->from('reset@example.com')
            ->to(new Address($user->getEmail()))
            ->subject('Reseting Password!')
        
            // path of the Twig template to render
            ->htmlTemplate('emails/reset.html.twig')
        
            // pass variables (name => value) to the template
            ->context([
                
                'resettoken' => $resettoken,
            ])
        ;
    
             $mailer->send($email);
             
             $this->addFlash('message','Reset password link has been sent');
             return $this->redirectToRoute('index');

        }return $this->render('security/reset.html.twig', [
            'emailForm' => $form->createView(),
            'categories' => $categorie,
        ]);

    }
    /**
     * @Route("/reset/{resettoken}",name="resettoken")
     * @param string $resettoken
     */
    public function reset(string $resettoken,CategorieRepository $categoRepository, Request $request, UserPasswordEncoderInterface $passwordEncoder) :response{
        $categorie = $categoRepository->findAll();
        $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(["resettoken" => $resettoken]);
        if($user){
           if($request->isMethod('POST')){
           $user->setResetToken(null);
           //chiffrement mtaa mdp
           $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('password')));
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();
           $this->addFlash("success","Mot de passe est modifié");
           return $this->redirectToRoute('app_login');
           }else{
            return $this->render('security/forgetpassword.html.twig', [
                'resettoken' => $resettoken,
                'categories' => $categorie
            ]);
           }
        } else{
            $this->addFlash("danger","Token inconnu"); // // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
            return $this->redirectToRoute('app_login');
        }
        return $this->json($resettoken);
       }
    /**
     *  @return string
     *  @throws \Exception
     */
    public function generateToken()
{
    return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
}
}
