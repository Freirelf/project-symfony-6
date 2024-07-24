<?php

namespace App\Controller;


use App\Service\NewsService;
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
    return $this->render(view: 'home/index.html.twig', parameters:[
      'pageTitle' => $pageTitle,
      'categories' => $service->getCategoryList(),
    ]);
  }

  #[Route('/category/{slug}', name: 'app_category')]
  public function category( string $slug=null, NewsService $service ): Response
  {  
    $pageTitle = 'BE News | '.$slug;
    return $this->render(view: 'category/category.html.twig', parameters:[
      'pageTitle' => $pageTitle,
      'categories' => $service->getCategoryList(),
      'news' => $service->getNewsList(),
    ]);
  }

  #[Route('/news/{id}')]
  public function newDatails(int $id=null, HttpClientInterface $httpClient)
  {
    $response = $httpClient->request('GET','https://127.0.0.1:8000/api/news/' . $id);
    dump($response);
    exit;
  }
}

