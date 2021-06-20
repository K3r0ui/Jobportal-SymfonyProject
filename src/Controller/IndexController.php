<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\OemploiRepository;
use App\Repository\CondidatRepository;
use App\Repository\CategorieRepository;
use App\Repository\RecruiterRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(OemploiRepository $oemploiRepository,CondidatRepository $repCondidat,RecruiterRepository $repRecruiter,CategorieRepository $categorieRep): Response
    {
        return $this->render('index/index.html.twig',  array(
            'oemplois' => $oemploiRepository->findAll()
        ,  
            'condidats' => $repCondidat->findAll()
        ,  
            'recruiters' => $repRecruiter->findAll()
        ,
            'categories' => $categorieRep->findAll()
        ));
    }
}
