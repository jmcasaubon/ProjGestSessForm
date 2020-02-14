<?php

namespace App\Repository;

use App\Entity\DeliciousElephant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DeliciousElephant|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliciousElephant|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliciousElephant[]    findAll()
 * @method DeliciousElephant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliciousElephantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliciousElephant::class);
    }

    // /**
    //  * @return DeliciousElephant[] Returns an array of DeliciousElephant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliciousElephant
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
