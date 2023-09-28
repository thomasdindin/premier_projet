<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ArticleController extends AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/addarticle', name: 'app_article')]
    public function add(Request $request): Response
    {
        $article = new Article();


        $form = $this->createForm(ArticleType::class, $article);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();
                $article->setAuteur($this->getUser());
                $article->setDateCreation(new \DateTime());

                $entityManager = $this->manager;
                $entityManager->persist($article);
                $entityManager->flush();

        
                return $this->redirectToRoute('app_home');
            }
        }


        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }
}
