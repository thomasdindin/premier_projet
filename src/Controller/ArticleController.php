<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticleController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/addarticle', name: 'app_article')]
    public function add(): Response
    {
        $article = new Article();
        $article->setAuteur($this->getUser());
        $article->setDateCreation(new \DateTime());

        $form = $this->createForm(ArticleType::class, $article);



        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }
}
