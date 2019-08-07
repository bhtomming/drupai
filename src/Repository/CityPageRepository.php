<?php

namespace App\Repository;

use App\Entity\CityPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CityPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CityPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CityPage[]    findAll()
 * @method CityPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityPageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CityPage::class);
    }

//    /**
//     * @return CityPage[] Returns an array of CityPage objects
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
    public function findOneBySomeField($value): ?CityPage
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
