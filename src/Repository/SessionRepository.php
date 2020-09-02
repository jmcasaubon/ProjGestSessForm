<?php
// 
// Interface BdD dédiée à l'entité "Session".
//
// Contient les méthodes de base d'extraction de la table associée stockée en BdD, ainsi que des méthodes personnalisées.
//

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

        $sql = $eMgr->createQuery("SELECT s 
                                   FROM App\Entity\Session s 
                                   ORDER BY s.dateDebut ASC, s.dateFin DESC") ;

        return $sql->execute() ;
    }

    public function getStagiairesNonInscrits($idSession)
    {
        $eMgr = $this->getEntityManager();

        // 1ère partie de la requête : on récupère la liste des stagiaires inscrits à la session
        $qb1 = $eMgr->createQueryBuilder();
        $qb1->select('s')
            ->from('App\Entity\Stagiaire', 's')
            ->leftJoin('s.sessions', 'se')
            ->where('se.id = :id')
            ;
            
        // 2ème partie de la requête : on récupère les stagiaires qui ne sont pas dans l'ensemble obtenu par la 1ère partie
        $qb2 = $eMgr->createQueryBuilder();
        $qb2->select('st')
            ->from('App\Entity\Stagiaire', 'st')
            ->where($qb2->expr()->notIn('st.id', $qb1->getDQL()))
            ->setParameter('id', $idSession)
            ->addOrderBy('st.nom', 'ASC')
            ->addOrderBy('st.prenom', 'ASC')
            ;
            
        // On exécute finalement la requête complète, et on retourne son résultat
        $sql = $qb2->getQuery();
        return $sql->getResult();
    }

    public function getModulesNonPresents($idSession)
    {
        $eMgr = $this->getEntityManager();

        // 1ère partie de la requête : on récupère la liste des modules déjà présents dans le programme de la session
        $qb1 = $eMgr->createQueryBuilder();
        $qb1->select('p.module')
            ->from('App\Entity\Programme', 'p')
            ->leftJoin('p.session', 's')
            ->where('s.id = :id')
            ;
            
        // 2ème partie de la requête : on récupère les modules qui ne sont pas dans l'ensemble obtenu par la 1ère partie
        $qb2 = $eMgr->createQueryBuilder();
        $qb2->select('m')
            ->from('App\Entity\Module', 'm')
            ->where($qb2->expr()->notIn('m.id', $qb1->getDQL()))
            ->setParameter('id', $idSession)
            ->OrderBy('m.categorieLibelle', 'ASC')
            ;
            
        // On exécute finalement la requête complète, et on retourne son résultat
        $sql = $qb2->getQuery();
        return $sql->getResult();
    }

    public function getAllFuture()
    {
        $eMgr = $this->getEntityManager() ;

        $sql = $eMgr->createQuery("SELECT s 
                                   FROM App\Entity\Session s 
                                   WHERE s.dateDebut > CURRENT_DATE()
                                   ORDER BY s.dateDebut ASC, s.dateFin DESC") ;

        return $sql->execute() ;
    }

    // public function getAllFutureNotFull()
    // {
    //     $eMgr = $this->getEntityManager() ;

    //     return $this->createQueryBuilder('s')
    //                     ->andWhere('s.dateDebut > CURRENT_DATE()')
    //                     ->andWhere('s.nbPlaces > :nbInscrits')
    //                     ->setParameter('nbInscrits', $this->s.nbPlacesRestantes)
    //                     ->orderBy('s.dateDebut', 'ASC')
    //                     ->getQuery()
    //                     ->getResult()
    //                     ;
    // }

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
