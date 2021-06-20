<?php

namespace App\Controller\Backend;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/backend/admin/index", name="backend_admin_home")
     */
    public function index(): Response
    {
        return $this->render('backend/index.html.twig');
    }

    /**
     * @Route("/backend/admin/show", name="backend_admin_show")
     */
    public function show(AdminRepository $adminRepo): Response
    {
        return $this->render('backend/admin/index.html.twig', [
            'admin' => $adminRepo->findAll()
        ]);
    }
    /**
     * @Route("/backend/admin/ajout", name="backend_admin_ajout")
     */
    public function ajoutAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $admin = new Admin();
    
        $form = $this->createForm(AdminType::class, $admin);
    
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $filepdp = $admin->getProfileimage();
            $fileNamepdp= md5(uniqid()).'.'.$filepdp->guessExtension();
            try {
                $filepdp->move(
                    $this->getParameter('apdpimage_directory'),
                    $fileNamepdp
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $admin->setPassword(
                $passwordEncoder->encodePassword(
                    $admin,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $admin->setRoles(array('ROLE_ADMIN'));
            $admin->setCreatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $admin->setProfileimage($fileNamepdp);
            $em->persist($admin);
            $em->flush();
    
            return $this->redirectToRoute('backend_admin_show');
        }
    
        return $this->render('backend/admin/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/backend/admin/modifier/{id}", name="backend_admin_modifier")
     */
    public function ModifAdmin(Admin $admin, Request $request)
    {
        $form = $this->createForm(AdminType::class, $admin);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){    
        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return $this->redirectToRoute('backend_admin_show');
        }
    
        return $this->render('backend/admin/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
        /**
     * @Route("/backend/admin/delete/{id}", name="backend_admin_del")
     */
    public function delete(Request $request, $id) {
        $admin = $this->getDoctrine()->getRepository(Admin::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($admin);
        $entityManager->flush();
  
        return $this->redirectToRoute('backend_admin_home');
      }

    
}
