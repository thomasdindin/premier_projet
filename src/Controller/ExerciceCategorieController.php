<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceCategorieController extends AbstractController
{
    #[Route('/lescategories', name: 'app_exercice_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository ->findAll();
        return $this->render('exercice_categorie/index.html.twig', [
            'controller_name' => 'ExerciceCategorieController',
            'categories' => $categories,
        ]);
    }
}
