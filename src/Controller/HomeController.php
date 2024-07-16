<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home')]
  public function index(LoggerInterface $logger): Response
  { 

    $logger->info('Hello World!');
    $categories = [
      ['title' =>  'World', 'text' => 'World news' ],
      ['title' =>  'Brazil', 'text' => 'Brazil news' ],
      ['title' =>  'Technology', 'text' => 'Technology news' ],
      ['title' =>  'Design', 'text' => 'Design news' ],
      ['title' =>  'Culture', 'text' => 'Culture news' ],
      ['title' =>  'Business', 'text' => 'Business news' ],
      ['title' =>  'Politics', 'text' => 'Politics news' ],
      ['title' =>  'Opinion', 'text' => 'Opinion news' ],
      ['title' =>  'Science', 'text' => 'Science news' ],
      ['title' =>  'Health', 'text' => 'Health news' ],
      ['title' =>  'Style', 'text' => 'Style news' ],
      ['title' =>  'Travel', 'text' => 'Travel news' ],
    ];

    $pageTitle = 'BE News';
    return $this->render(view: 'home/index.html.twig', parameters:[
      'categories' => $categories,
      'pageTitle' => $pageTitle
    ]);
  }

  #[Route('/category/{slug}', name: 'app_category')]
  public function category( string $slug=null): Response
  {  

    $categories = [
      ['title' =>  'World', 'text' => 'World news' ],
      ['title' =>  'Brazil', 'text' => 'Brazil news' ],
      ['title' =>  'Technology', 'text' => 'Technology news' ],
      ['title' =>  'Design', 'text' => 'Design news' ],
      ['title' =>  'Culture', 'text' => 'Culture news' ],
      ['title' =>  'Business', 'text' => 'Business news' ],
      ['title' =>  'Politics', 'text' => 'Politics news' ],
      ['title' =>  'Opinion', 'text' => 'Opinion news' ],
      ['title' =>  'Science', 'text' => 'Science news' ],
      ['title' =>  'Health', 'text' => 'Health news' ],
      ['title' =>  'Style', 'text' => 'Style news' ],
      ['title' =>  'Travel', 'text' => 'Travel news' ],
    ];

    $pageTitle = 'BE News | '.$slug;
    return $this->render(view: 'category/category.html.twig', parameters:[
      'categories' => $categories,
      'pageTitle' => $pageTitle
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

