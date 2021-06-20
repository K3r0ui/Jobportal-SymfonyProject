<?php

namespace App\Controller\Backend;
use App\Entity\Admin;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AdminTypeAccess;
class AccessController extends AbstractController
{
    /**
     * @Route("/backend/access/show", name="backend_access_show")
     */
    public function access(AdminRepository $adminRepo): Response
    {
        return $this->render('backend/access/index.html.twig', [
            'admin' => $adminRepo->findAll()
        ]);
    }
        /**
     * @Route("/backend/access/modifier/{id}", name="backend_access_modifier")
     */
    public function ModifAccess(Admin $admin, Request $request)
    {
        $form = $this->createForm(AdminTypeAccess::class, $admin);
    
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        return $this->redirectToRoute('backend_access_show');
        }
    
        return $this->render('backend/access/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
