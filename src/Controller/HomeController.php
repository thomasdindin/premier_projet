<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'titre' => 'Bienvenue sur mon site',
            'articles' => $articles,
            'username' => $this->getUser()
        ]);
    }

    #[Route('/home/prenom', name: 'app_home_prenom')]
    public function prenom($prenom): Response
    {
        return $this->render('home/prenom.html.twig', [
            'controller_name' => 'HomeController',
            'prenom' => 'Thomas',
        ]);
    }

    #[Route('/home/contact', name: 'app_home_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'titre' => 'Bienvenue sur mon site',
        ]);
    }

}
