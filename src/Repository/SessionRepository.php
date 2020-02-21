<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function getAll()
    {
        $eMgr = $this->getEntityManager() ;

        $sql = $eMgr->createQuery("SELECT s FROM App\Entity\Session s ORDER BY s.dateDebut ASC, s.dateFin DESC") ;

        return $sql->execute() ;
    }

    public function getAllFuture()
    {
        $eMgr = $this->getEntityManager() ;

        $sql = $eMgr->createQuery("SELECT s 
                                   FROM App\Entity\Session s 
                                   WHERE s.dateDebut > CURRENT_DATE()
                                   ORDER BY s.dateDebut ASC") ;

        return $sql->execute() ;
    }

    public function getAllFutureNotFull()
    {
        $eMgr = $this->getEntityManager() ;

        return $this->createQueryBuilder('s')
                        ->andWhere('s.dateDebut > CURRENT_DATE()')
                        ->andWhere('s.nbPlaces > :nbInscrits')
                        ->setParameter('nbInscrits', $this->s.nbPlacesRestantes)
                        ->orderBy('s.dateDebut', 'ASC')
                        ->getQuery()
                        ->getResult()
                        ;
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
