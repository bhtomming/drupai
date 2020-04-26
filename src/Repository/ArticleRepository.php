<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


//    /**
//     * @return Article[] Returns an array of Article objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /*public function findLatest(int $page = 1): Pagerfanta
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT a, u, g
                FROM App:Article a
                JOIN a.author u
                LEFT JOIN a.category g
                WHERE a.createdAt <= :now
                ORDER BY a.createdAt DESC
            ')
            ->setParameter('now', new \DateTime())
        ;

        return $this->createPaginator($query, $page);
    }*/

    public function findLatest(int $page = 1): Pagerfanta
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT a, u
                FROM App:Article a
                JOIN a.author u
                WHERE a.createdAt <= :now
                ORDER BY a.createdAt DESC
            ')
            ->setParameter('now', new \DateTime())
        ;

        return $this->createPaginator($query, $page);
    }

    public function createPaginator(Query $query, int $page = 1): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Article::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function createPaginatorForArray(array $arr, int $page = 1,int $max = null): Pagerfanta
    {
        $paginator = new Pagerfanta(new ArrayAdapter($arr));
        $paginator->setMaxPerPage($max ? : Article::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function createPaginatorFromORMByCategory(string $id,int $page): Pagerfanta
    {
        $query = $this->createQueryBuilder('a')
            ->join('a.category','g')
            ->where('g.id=:c')
            ->setParameter('c',$id)
            ->orderBy('a.createdAt','DESC')
            ->getQuery()
            ;
        return $this->createPaginator($query,$page);
    }

    public function findByCategory($category)
    {
        $query = $this->createQueryBuilder('a')
            ->join('a.category','g')
            ->where('g.id=:c')
            ->setParameter('c',$category)
            ->orderBy('a.createdAt','DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }
}
