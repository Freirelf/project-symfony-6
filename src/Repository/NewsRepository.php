<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private CacheInterface $cache)
    {

    }

    public function findAll(): array
    {
        $news = $this->cache->get('news_data', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/JonasPoli/array-news/6592605d783b39aa2edac63868959ded7ef700ec/arrayNews.json');
            return $response->toArray();
        });
        return $news;
    }

    public function findAllCategories(): array
    {
        $categories = $this->cache->get('category_data', function (CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter(5);
            $response = $this->httpClient->request('GET', 'https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayCategoryNews.json');
            return $response->toArray();
        });
        return $categories;
    }
}
