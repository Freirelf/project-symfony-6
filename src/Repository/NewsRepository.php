<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private NewsCategoryRepository $newsCategoryRepository)
    {
        parent::__construct($registry, News::class);
    }

    public function save(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(News $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCategoryTitle(string $title):array
    {
        $category = $this->newsCategoryRepository->findOneBy(['title' => $title]);
        $newsCollection = $this->findBy(['category' => $category],['createAt' => 'DESC']);

        return $newsCollection;
    }

//    /**
//     * @return News[] Returns an array of News objects
//     */
   public function findBySearch($value): array
   {
       return $this->createQueryBuilder('n')
           ->andWhere('n.title like :val')
           ->setParameter('val', '%'.$value.'%')           
           ->orderBy('n.createAt', 'DESC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    /**
//     * @return News[] Returns an array of News objects
//     */
public function createQueryBuilderBySearch($value): QueryBuilder
{
    return $this->createQueryBuilder('n')
        ->andWhere('n.title like :val')
        ->setParameter('val', '%'.$value.'%')           
        ->orderBy('n.createAt', 'DESC')
        
    ;
}

//    /**
//     * @return News[] Returns an array of News objects
//     */
public function createQueryBuilderByCategoryTitle($value): QueryBuilder
{
    return $this->createQueryBuilder('n')
        ->join('n.category','c')
        ->andWhere('c.title like :val')
        ->setParameter('val', '%'.$value.'%')           
        ->orderBy('n.createAt', 'DESC')
        
    ;
}

public function findLastNews(int $qnt=5): Array 
   {
       return $this->createQueryBuilder('n')
           ->orderBy('n.createAt', 'DESC')
           ->setMaxResults($qnt)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?News
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
