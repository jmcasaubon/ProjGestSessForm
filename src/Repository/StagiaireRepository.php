<?php
// 
// Interface BdD dédiée à l'entité "Stagiaire".
//
// Contient les méthodes de base d'extraction de la table associée stockée en BdD, ainsi que des méthodes personnalisées.
//

namespace App\Repository;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

    public function getAll()
    {
        $eMgr = $this->getEntityManager() ;

        $sql = $eMgr->createQuery("SELECT s FROM App\Entity\Stagiaire s WHERE s.nom NOT LIKE '_Anonymous_%' ORDER BY s.nom ASC, s.prenom ASC") ;

        return $sql->execute() ;
    }

    public function getAnonymous()
    {
        $eMgr = $this->getEntityManager() ;

        $sql = $eMgr->createQuery("SELECT s FROM App\Entity\Stagiaire s WHERE s.nom LIKE '_Anonymous_%' ORDER BY s.nom ASC") ;

        return $sql->execute() ;

    }

    public function getSessionsNonParticipant($idStagiaire){

        $eMgr = $this->getEntityManager();

        // 1ère partie de la requête : on récupère la liste des sessions auxquelles le stagiaire participe déjà
        $qb1 = $eMgr->createQueryBuilder();
        $qb1->select('s')
            ->from('App\Entity\Session', 's')
            ->leftJoin('s.stagiaires', 'st')
            ->where('st.id = :id')
            ;
            
        // 2ème partie de la requête : on récupère les sessions futures qui ne sont pas dans l'ensemble obtenu par la 1ère partie
        $qb2 = $eMgr->createQueryBuilder();
        $qb2->select('se')
            ->from('App\Entity\Session', 'se')
            ->where('se.dateDebut > CURRENT_DATE()')
            ->andWhere($qb2->expr()->notIn('se.id', $qb1->getDQL()))
            ->setParameter('id', $idStagiaire)
            ->addOrderBy('se.dateDebut', 'ASC')
            ->addOrderBy('se.dateFin', 'DESC')
            ;
            
        // On exécute finalement la requête complète, et on retourne son résultat
        $sql = $qb2->getQuery();
        return $sql->getResult();
    }

    // /**
    //  * @return Stagiaire[] Returns an array of Stagiaire objects
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
    public function findOneBySomeField($value): ?Stagiaire
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
