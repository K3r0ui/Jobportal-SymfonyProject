<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(CategorieRepository $categoRepository): Response
    {
        $categorie = $categoRepository->findAll();
        return $this->render('index/categories.html.twig', array(
            'categories' => $categorie
));
    }
        /**
     * @Route("/header", name="header")
     */
    public function header( CategorieRepository $categoRepository): Response
    {
        $categorie = $categoRepository->findAll();
        return $this->render('header.html.twig', array(
            'categories' => $categorie
));
    }
}
