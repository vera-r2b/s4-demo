<?php

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('article/homepage.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        /** @var ArticleRepository $articleRepo */
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        /** @var Article $article | null */
        $article = $articleRepo->findOneBy(['slug' => $slug]);

        return $this->render('article/show.html.twig',[
            'article' => $article,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //TODO - actually heart/unheart the article

        $logger->info('Article is being heart-ed!');

        return new JsonResponse(['hearts' => rand(5,100)]);
    }
}