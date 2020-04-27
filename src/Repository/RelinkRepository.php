<?php

namespace App\Repository;

use App\Entity\Relink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Relink|null find($id, $lockMode = null, $lockVersion = null)
 * @method Relink|null findOneBy(array $criteria, array $orderBy = null)
 * @method Relink[]    findAll()
 * @method Relink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Relink::class);
    }

    // /**
    //  * @return Relink[] Returns an array of Relink objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Relink
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
