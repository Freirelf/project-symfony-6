<?php

namespace App\Service;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsService
{
  public function __construct(
    private HttpClientInterface $httpClient, 
    private CacheInterface $cache,
    #[Autowire('%kernel.debug%')] 
    private bool $isDebug)
  {

  }
  public function findAll(): array
  {
    $categories = $this->cache->get('news_category', function (CacheItemInterface $cacheItem) {
      $cacheItem->expiresAfter($this->isDebug ? 5 : 60);

      $url= "https://raw.githubusercontent.com/JonasPoli/array-news/6592605d783b39aa2edac63868959ded7ef700ec/arrayNews.json";
      $html = $this->httpClient->request('GET', $url);
      $news = $html->toArray();  

      return $news;
    });
    
    return $categories;
  }

  public function findAllCategories():array
  {
    $newsList = $this->cache->get('news_list', function (CacheItemInterface $cacheItem) {
      $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
      $url= "https://raw.githubusercontent.com/JonasPoli/array-news/main/arrayCategoryNews.json";
      $html = $this->httpClient->request('GET', $url);
      $news = $html->toArray();  
      
      return $news;
    });

    return $newsList;
  }

}