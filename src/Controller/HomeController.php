<?php

namespace App\Controller;


use App\Entity\News;
use App\Entity\NewsCategory;
use App\Repository\NewsCategoryRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(NewsCategoryRepository $newsCategoryRepository,NewsRepository $newsRepository ): Response
    {   

        $categories = $newsCategoryRepository->findAllCategoriesOrderByTitle();
        $news = $newsRepository->findLastNews(10);

        $pageTitle = 'BE News';
        return $this->render(view: 'home/index.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'categories'=> $categories,
            'news' => $news
        ]);
    }

    #[Route('/category/{slug}', name: 'app_category')]
    public function category(
        string $slug = null, 
        NewsCategoryRepository $newsCategoryRepository, 
        NewsRepository $newsRepository, 
        Request $request): Response
    {   
        $queryBuilder = $newsRepository->createQueryBuilderByCategoryTitle($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request ->query->get('page',1),
            6,
        );
        // $news = $newsRepository->findByCategoryTitle($slug);
        $pageTitle = 'BE News | ' . $slug;

        $categories = $newsCategoryRepository->findAllCategoriesOrderByTitle();

        return $this->render(view: 'category/category.html.twig', parameters: [
            'pageTitle' => $pageTitle,
            'pager' => $pagerFanta,
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
        // $listNews = $newsRepository->findBySearch($request->query->get('search'));
        $queryBuilder = $newsRepository->createQueryBuilderBySearch($search);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page',1),
            6
        );
        return $this->render('search/search.html.twig', [
            // 'news' => $listNews,
            'pager' => $pagerFanta,
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

    #[Route('/data/', name: 'app_news_date')]
    public function filterDate(Request $request, NewsRepository $newsRepository,NewsCategoryRepository $categoryRepository): Response
    {
        $year = $request->query->get('ano');
        $month = $request->query->get('mes');

        if (strlen($month) == 1){
            $month = "0".$month;
        }

        $categories = $categoryRepository->findAll();

        // $news = $newsRepository->findBySearch($search);
        $queryBuilder = $newsRepository->createQueryBuilderByDate($year,$month);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page',1),
            6
        );

        // montar a string do mês e ano
        $formatter = new \IntlDateFormatter('pt_BR', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, pattern: "MMMM Y");
        $searchString  = $year.'-'.$month.'-01';

        return $this->render('search/search.html.twig', [
            'pageTitle' => 'Resultado da pesquisa',
            'categories' => $categories,
            'pager' => $pagerFanta,
            'search' => $formatter->format(date( strtotime($searchString))),
        ]);
    }
}
