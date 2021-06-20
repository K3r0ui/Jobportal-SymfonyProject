<?php

namespace App\Controller;

use App\Entity\Oemploi;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Repository\OemploiRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechercheController extends AbstractController
{
     /**
     * @Route("/recherche", name="joballrecherche")
     */
    public function recherche(OemploiRepository $oemploirep, CategorieRepository $categoRepository,Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class , $data);
        $form->handleRequest($request);
        [$min,$max] = $oemploirep->findMinMax($data);
        //dd($data);
        $oemploi= $oemploirep->findSearch($data);
        
        $categorie = $categoRepository->findAll();
        return $this->render('index/recherche.html.twig',  array(
            'oemplois' => $oemploi,
            'categories' => $categorie,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max,
));
    }
     
}
