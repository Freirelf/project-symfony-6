<?php

namespace App\Controller;


use App\Entity\News;
use App\Service\NewsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(NewsService $service): Response
    {
        $pageTitle = 'BE News';
        return $this->render(view: 'home/index.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'categories' => $service->getCategoryList(),
        ]);
    }

    #[Route('/category/{slug}', name: 'app_category')]
    public function category(string $slug = null, NewsService $service): Response
    {
        $pageTitle = 'BE News | ' . $slug;
        return $this->render(view: 'category/category.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'categories' => $service->getCategoryList(),
            'news' => $service->getNewsList(),
        ]);
    }

    #[Route('/news/new')]
    public function new(EntityManagerInterface $entityManager)
    {   
        $rand = rand(18, 30);
        $news = new News();
        $news->setTitle('Nova noticia: Aos ' . $rand . ' anos, fique rico');
        $news->setDescription('Para ficar rico com '. $rand .' anos! Estratégia de investimento...');
        $entityManager->persist($news);
        $entityManager->flush();
        return new Response('<h1>News Created:</h1>em:'.$news->getCreateAt()->format('Y-m-d H:i:s'));
    }

    #[Route('/news/{id}')]
    public function newDetails(int $id = null, HttpClientInterface $httpClient)
    {
        // $response = $httpClient->request('GET', 'https://127.0.0.1:8000/api/news/' . $id);
        dd('hello');
        return new Response();
    }
}
