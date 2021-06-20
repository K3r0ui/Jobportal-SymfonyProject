<?php

namespace App\Controller\Backend;

use App\Entity\Recruiter;
use App\Form\RecruiterType;
use App\Repository\RecruiterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecruiterController extends AbstractController
{
    /**
     * @Route("/backend/recruiter/show", name="backend_recruiter_home")
     */
    public function index(RecruiterRepository $recRepo): Response
    {
        return $this->render('backend/recruiter/index.html.twig', [
            'recruiter' => $recRepo->findAll()
        ]);
    }
    /**
     * @Route("/backend/recruiter/ajout", name="backend_recruiter_ajout")
     */
    public function ajoutRecruiter(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $recruiter = new Recruiter();
    
        $form = $this->createForm(RecruiterType::class, $recruiter);
    
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $filepdp = $recruiter->getProfileimage();
            $fileNamepdp= md5(uniqid()).'.'.$filepdp->guessExtension();
            try {
                $filepdp->move(
                    $this->getParameter('rpdpimage_directory'),
                    $fileNamepdp
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $recruiter->setPassword(
                $passwordEncoder->encodePassword(
                    $recruiter,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $recruiter->setRoles(array('ROLE_RECRUITER'));
            $recruiter->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $recruiter->setProfileimage($fileNamepdp);
            $em->persist($recruiter);
            $em->flush();
    
            return $this->redirectToRoute('backend_recruiter_home');
        }
    
        return $this->render('backend/recruiter/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/backend/recruiter/modifier/{id}", name="backend_recruiter_modifier")
     */
    public function ModifRecruiter(Recruiter $recruiter, Request $request)
    {
        $form = $this->createForm(RecruiterType::class, $recruiter);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){    
        $em = $this->getDoctrine()->getManager();
        $em->persist($recruiter);
        $em->flush();

        return $this->redirectToRoute('backend_recruiter_home');
        }
    
        return $this->render('backend/recruiter/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
        /**
     * @Route("/backend/recruiter/delete/{id}", name="backend_recruiter_del")
     */
    public function delete(Request $request, $id) {
        $recruiter = $this->getDoctrine()->getRepository(Recruiter::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($recruiter);
        $entityManager->flush();
  
        return $this->redirectToRoute('backend_recruiter_home');
      }
    }
