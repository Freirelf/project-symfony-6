<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function index(HttpClientInterface $httpClient): Response
  { 
    $pageTitle = 'BE News';
    return $this->render(view: 'home/index.html.twig', parameters:[
      'categories' => $this->getCategoryList($httpClient),
      'pageTitle' => $pageTitle
    ]);
  }

  #[Route('/category/{slug}', name: 'app_category')]
  public function category( string $slug=null, HttpClientInterface $httpClient  ): Response
  {  
    $pageTitle = 'BE News | '.$slug;
    return $this->render(view: 'category/category.html.twig', parameters:[
      'pageTitle' => $pageTitle,
      'categories' => $this->getCategoryList($httpClient),
      'news' => $this->getNewsList($httpClient),
    ]);
  }

  public function getCategoryList( $httpClient ){
    $url= "https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayCategoryNews.json";
    $html = $httpClient->request('GET', $url);
    $news = $html->toArray();  

    return $news;
  }

  public function getNewsList( $httpClient ){
    $url= "https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayNews.json";
    $html = $httpClient->request('GET', $url);
    $news = $html->toArray();  

    return $news;
  }
  #[Route('/news/{id}')]
  public function newDatails(int $id=null, HttpClientInterface $httpClient)
  {
    $response = $httpClient->request('GET','https://127.0.0.1:8000/api/news/' . $id);
    dump($response);
    exit;
  }
}

