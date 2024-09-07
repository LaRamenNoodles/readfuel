<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\Type\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    public function __construct(private readonly ArticleRepository $articleRepository) {}

    #[Route(path: 'article/create', name: 'article_create', methods: ['GET', 'POST'])]
    public function createArticle(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->articleRepository->save($article);
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
