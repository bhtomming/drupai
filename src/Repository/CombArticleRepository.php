<?php

namespace App\Repository;

use App\Entity\CombArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method CombArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CombArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CombArticle[]    findAll()
 * @method CombArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CombArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CombArticle::class);
    }

//    /**
//     * @return CombArticle[] Returns an array of CombArticle objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CombArticle
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
