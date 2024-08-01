<?php

namespace App\Controller;


use App\Entity\News;
use App\Entity\NewsCategory;
use App\Repository\NewsCategoryRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(NewsCategoryRepository $newsCategoryRepository): Response
    {   

        $categories = $newsCategoryRepository->findAllCategoriesOrderByTitle();

        $pageTitle = 'BE News';
        return $this->render(view: 'home/index.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'categories'=> $categories
        ]);
    }

    #[Route('/category/{slug}', name: 'app_category')]
    public function category(string $slug = null, NewsCategoryRepository $newsCategoryRepository, NewsRepository $newsRepository,): Response
    {   
        $news = $newsRepository->findByCategoryTitle($slug);
        $pageTitle = 'BE News | ' . $slug;

        $categories = $newsCategoryRepository->findAllCategoriesOrderByTitle();

        return $this->render(view: 'category/category.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'news' => $news,
            'categories' => $categories,
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

    #[Route('/search', name: 'app_news_filter')]
    public function filter(Request $request, NewsRepository $newsRepository):Response
    {   
        $search = $request->query->get('search');
        $listNews = $newsRepository->findBySearch($request->query->get('search'));

        return $this->render('search/search.html.twig', [
            'news' => $listNews,
            'search' => $search,
        ]);
    }

    #[Route('/news/{slug}', name: 'app_news_detail')]
    public function newDetails(News $news=null): Response
    {
        if (!$news) {
            throw $this->createNotFoundException('Noticia não encontrada');
        }
        return $this->render('details/newsDetail.html.twig', [
           'news' => $news,
        ]);

    }
}
