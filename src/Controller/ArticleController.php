<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
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
            'username' => $this->getUser(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/modifarticle/{id}', name: 'app_edit_article')]
    public function edit(Request $request, $id, ArticleRepository $repo): Response
    {
        
        $entityManager = $this->manager;
        $article = $repo->find($id);

        $article->setTitre($article->getTitre());
        $article->setContenu($article->getContenu());
        $article->setDateCreation($article->getDateCreation());
        $article->setAuteur($article->getAuteur());


        $form = $this->createForm(ArticleType::class, $article);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
        
            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();
                $entityManager->persist($article);
                $entityManager->flush();

        
                return $this->redirectToRoute('app_home');
            }
        }


        return $this->render('article/edit.html.twig', [
            'form' => $form,
            'username' => $this->getUser(),
            'id' => $id,
        ]);
    }
}
