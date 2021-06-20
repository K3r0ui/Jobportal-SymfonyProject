<?php

namespace App\Controller\Backend;

use App\Entity\Condidat;
use App\Repository\CondidatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RulesController extends AbstractController
{
   /**
     * @Route("/backend/rules", name="backend_rules_home")
     */
    public function index(CondidatRepository $condidatRepo): Response
    {
        
        return $this->render('backend/rules/index.html.twig', [
            'condidat' => $condidatRepo->findBy(['enabled' => 0])
        ]);
    }
      /**
       * @Route("/backend/rules/delete/{id}", name="backend_rules_del")
       */
      public function rules (Request $request, $id){
          
      }
}
