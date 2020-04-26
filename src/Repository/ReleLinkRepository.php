<?php

namespace App\Repository;

use App\Entity\ReleLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method ReleLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReleLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReleLink[]    findAll()
 * @method ReleLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReleLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReleLink::class);
    }

//    /**
//     * @return ReleLink[] Returns an array of ReleLink objects
//     */
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
    public function findOneBySomeField($value): ?ReleLink
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
