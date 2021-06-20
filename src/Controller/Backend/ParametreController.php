<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ParametreRepository;
use App\Entity\Parametre;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ParametreType;


class ParametreController extends AbstractController
{
    /**
     * @Route("/backend/parametre", name="backend_parametre")
     */
    public function index(ParametreRepository $paramrepo): Response
    {
        return $this->render('backend/parametre/index.html.twig', [
            'param' => $paramrepo->findAll()
        ]);
    }
        /**
     * @Route("/backend/parametre/modifier/{nom}", name="parametre_backend_modif")
     */
    public function modifier(Request $request , Parametre $param): Response
    {
        $form = $this->createForm(ParametreType::class, $param);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid()){    
        $em = $this->getDoctrine()->getManager();
        $em->persist($param);
        $em->flush();

        return $this->redirectToRoute('backend_parametre');
        }
    
        return $this->render('backend/parametre/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/backend/parametre/delete/{nom}", name="parametre_backend_delete")
     */
    public function delete(Request $request, $nom) {
        $parametre = $this->getDoctrine()->getRepository(Parametre::class)->find($nom);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($parametre);
        $entityManager->flush();
  
        return $this->redirectToRoute('backend_parametre');
      }
}
