<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessController extends AbstractController
{
    /**
     * @Route("/access", name="access")
     */
    public function index(CategorieRepository $categoRepository): Response
    {
        $categorie = $categoRepository->findAll();
        return $this->render('access/index.html.twig', [
            'categories' => $categorie,
        ]);
    }
}
