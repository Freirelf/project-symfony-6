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
      'pageTitle' => $pageTitle,
      'news' => $this->getNewsList(),
    ]);
  }

  public function getNewsList(){
    $news = [
      [
        "title" => "Nova descoberta arqueológica no Egito",
        "description" => "Arqueólogos descobriram uma nova tumba faraônica com artefatos e múmias bem preservadas.",
        "image" => "https://loremflickr.com/419/225/{{ pageTitle }}?random=1",
        "create_at" => new \DateTime("2022-01-15 10:00:00")
    ],
    [
        "title" => "Empresa anuncia novo produto revolucionário",
        "description" => "A empresa XYZ anunciou o lançamento de um novo produto que promete mudar o mercado.",
        "image" => "https://loremflickr.com/419/225?random=2",
        "create_at" => new \DateTime("2022-01-14 15:30:00")
    ],
    [
        "title" => "Novo estudo revela impactos do aquecimento global",
        "description" => "Um novo estudo mostra que o aquecimento global está causando mudanças drásticas em ecossistemas marinhos.",
        "image" => "https://loremflickr.com/419/225?random=3",
        "create_at" => new \DateTime("2022-01-13 09:45:00")
    ],
    [
        "title" => "Atleta brasileiro ganha medalha de ouro em competição internacional",
        "description" => "O atleta brasileiro João da Silva conquistou a medalha de ouro no campeonato mundial de atletismo.",
        "image" => "https://loremflickr.com/419/225?random=4",
        "create_at" => new \DateTime("2022-01-12 16:20:00")
    ],
    [
        "title" => "Novo filme de super-herói bate recorde de bilheteria",
        "description" => "O novo filme da franquia 'Super-Herói X' bateu recorde de bilheteria em sua primeira semana de exibição.",
        "image" => "https://loremflickr.com/419/225?random=5",
        "create_at" => new \DateTime("2022-01-11 13:10:00")
    ],
    [
        "title" => "Pesquisadores descobrem nova espécie de animal marinho",
        "description" => "Pesquisadores da Universidade de São Paulo descobriram uma nova espécie de peixe em águas profundas do oceano Atlântico.",
        "image" => "https://loremflickr.com/419/225?random=6",
        "create_at" => new \DateTime("2022-01-10 11:00:00")
    ],
    [
        "title" => "Grande incêndio atinge área de preservação ambiental",
        "description" => "Um grande incêndio atingiu uma área de preservação ambiental no estado do Amazonas.",
        "image" => "https://loremflickr.com/419/225?random=7",
        "create_at" => new \DateTime("2022-01-09 19:15:00")
    ],
    [
        "title" => "Novo parque é inaugurado na cidade",
        "description" => "A prefeitura inaugura o novo parque da cidade, com diversas atrações para todas as idades.",
        "image" => "https://loremflickr.com/419/225?random=8",
        "create_at" => new \DateTime('2022-02-10'),
    ],
    [
        "title" => "Acidente grave na rodovia",
        "description" => "Um acidente envolvendo três veículos deixou quatro pessoas feridas na rodovia BR-101.",
        "image" => "https://loremflickr.com/419/225?random=9",
        "create_at" => new \DateTime('2023-02-16 12:50'),
    ],
    ];

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

