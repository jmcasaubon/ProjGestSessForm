<?php

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Stagiaire;
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

    public function getAll(){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT s 
                FROM App\Entity\Session s 
                ORDER BY s.dateDebut"
        );
        return $query->execute();
    }

    public function getNonInscrits($idSession){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        $qb->select('s')
            ->from('App\Entity\Stagiaire','s')
            ->leftJoin('s.sessions','se')
            ->where('se.id = :id');
            
        $sub = $em->createQueryBuilder();
        $sub->select('st')
            ->from('App\Entity\Stagiaire','st')
            ->where($sub->expr()->notIn('st.id', $qb->getDQL()))
            ->setParameter('id',$idSession)
            ->orderBy('st.nomStagiaire');
            
        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function getModulesNonProg($idSession) {


    }
}
