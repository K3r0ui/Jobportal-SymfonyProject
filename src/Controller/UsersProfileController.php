<?php

namespace App\Controller;

use App\Repository\RdvRepository;
use App\Form\EditProfileCondidatType;
use App\Repository\DemploiRepository;
use App\Form\EditProfileCvCondidatType;
use App\Repository\CategorieRepository;
use App\Form\EditProfilePdpCondidatType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class UsersProfileController extends AbstractController
{
    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile", name="profile")
     */
    public function index(CategorieRepository $categoRepository): Response
    {   $categorie = $categoRepository->findAll();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'UsersProfileController',
            'categories' => $categorie
        ]);
    }

    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile/condidat", name="profile_condidat_modif")
     */
    public function editProfile(CategorieRepository $categoRepository, Request $request): Response
    {
        $condidat = $this->getUser();
        $categorie = $categoRepository->findAll();
        $form = $this->createForm(EditProfileCondidatType::class, $condidat);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condidat);
            $entityManager->flush();
            $this->addFlash('message', 'profile updated succesfully');
            return $this->redirectToRoute('profile')  ;
        }
        return $this->render('profile/editprofile.html.twig', ['form' => $form->createView(),
        'categories' => $categorie
        ]);
    }
    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile/condidat/pdp", name="profile_condidat_modif_pdp")
     */
    public function editProfileimage(CategorieRepository $categoRepository,Request $request): Response
    {
        $condidat = $this->getUser();
        $categorie = $categoRepository->findAll();
        $form = $this->createForm(EditProfilePdpCondidatType::class, $condidat);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
           $filepdp = $condidat->getProfileimage();
            
            
           $fileNamepdp= md5(uniqid()).'.'.$filepdp->guessExtension();
            try {
               $filepdp->move(
                   $this->getParameter('cpdpimage_directory'),
                    $fileNamepdp
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $condidat->setProfileimage($fileNamepdp);
            $entityManager->persist($condidat);
            $entityManager->flush();
            $this->addFlash('message', 'photo du profile updated succesfully');
            return $this->redirectToRoute('profile')  ;
        }
        return $this->render('profile/editprofileimage.html.twig', ['form' => $form->createView(),
        'categories' => $categorie
        ]);
    }
    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile/condidat/cv", name="profile_condidat_modif_cv")
     */
    public function editCv(CategorieRepository $categoRepository,Request $request): Response
    {
        $condidat = $this->getUser();
        $categorie = $categoRepository->findAll();
        $form = $this->createForm(EditProfileCvCondidatType::class, $condidat);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filecv = $condidat->getCvimage();
            $fileNamecv= md5(uniqid()).'.'.$filecv->guessExtension();
            try {
                $filecv->move(
                    $this->getParameter('ccvimage_directory'),
                    $fileNamecv
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $condidat->setCvimage($fileNamecv);
            $entityManager->persist($condidat);
            $entityManager->flush();
            $this->addFlash('message', 'cv updated succesfully');
            return $this->redirectToRoute('profile')  ;
        }
        return $this->render('profile/editprofilecv.html.twig', ['form' => $form->createView(),
        'categories' => $categorie
        ]);
    }
    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile/condidat/pass", name="profile_condidat_modif_pass")
     */
    public function editPassword(CategorieRepository $categoRepository,Request $request, UserPasswordEncoderInterface $passencoder): Response
    {
        $condidat = $this->getUser();
        $categorie = $categoRepository->findAll();
        $form = $this->createForm(EditProfilePdpCondidatType::class, $condidat);
    
        $form->handleRequest($request);
        if ( $request->isMethod('POST')){
            $entityManager = $this->getDoctrine()->getManager();
            $condidat = $this->getUser();
            if($request->request->get('fpassword') == $request->request->get('cpassword')){
                $condidat->setPassword($passencoder->encodePassword($condidat,$request->request->get('fpassword')));
                $entityManager->flush();
                $this->addFlash('message',' Mot de passe updated successfully ');
                return $this->redirectToRoute('profile');
            }else{
                $this->addFlash('error',' Password Doesn\'t match ');
            }
        }

        return $this->render('profile/editpassword.html.twig', ['categories' => $categorie]);
    }
    /**
     * @IsGranted("ROLE_CONDIDAT")
     * @Route("/profile/myapplication", name="myapplication")
     */
    public function myApplication(CategorieRepository $categoRepository,DemploiRepository $demploiRepository,Request $request, RdvRepository $rdvRep): Response
    {
        $categorie = $categoRepository->findAll();
        $rdv = $rdvRep->findAll();
        $condidat = $this->getUser()->getId();
        $myapplication = $demploiRepository->findBy(['idcondidat' => $condidat]);

        return $this->render('profile/myapplication.html.twig', ['categories' => $categorie, 'myapplication' => $myapplication , 'rdv' => $rdv]);
    }
}
