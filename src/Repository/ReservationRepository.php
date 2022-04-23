<?php

namespace App\Repository;


use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use App\Entity\Reservation;
use App\Entity\Hebergement;
use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;


/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
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
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function avg(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select AVG(v.prix) from App\Entity\Reservation r, App\Entity\Vol v where v.volId = r.vol  ');
        return $query->getSingleScalarResult();   
     }




//sort by multi 

    
    public function indiv(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select r from App\Entity\Reservation r where r.type= ?1  ')
        ->setParameter(1,'Individuelle');
        return $query->getResult();
    }

    public function voyage(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select r from App\Entity\Reservation r where r.type= ?1  ')
        ->setParameter(1,'Voyage Organisé');
        return $query->getResult();
    }
public function orderbyprix(){
    $em=$this->getEntityManager();
    $query=$em->createQuery('select r from App\Entity\Reservation r, App\Entity\Vol v where v.volId = r.vol order by v.prix ASC ');
    return $query->getResult();
}
    public function orderbyprixd()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('select r from App\Entity\Reservation r, App\Entity\Vol v where v.volId = r.vol order by v.prix DESC ');
        return $query->getResult();
    }

    public function dest()
    {
        $em = $this->getEntityManager();
        $q=$em->createQuery(' SELECT COUNT(r1.vol) Destnbr FROM App\Entity\Reservation r1 GROUP BY r1.vol ORDER BY COUNT(r1.vol) DESC  ')
        ->setMaxResults(1);
         $query = $em->createQuery('SELECT COUNT(r.vol) Destnbr, v.destination BestDestination FROM App\Entity\Reservation r, App\Entity\Vol v WHERE v.volId = r.vol GROUP by r.vol HAVING COUNT(r.vol) = ?1')
         ->setParameter(1,$q->getResult());
        return $query->getResult();
    }
    public function heber()
    {
        $em = $this->getEntityManager();
        $q=$em->createQuery(' SELECT COUNT(r1.hebergement) FROM App\Entity\Reservation r1 GROUP BY r1.hebergement ORDER BY COUNT(r1.hebergement) DESC ')
        ->setMaxResults(1);
         $query = $em->createQuery('SELECT COUNT(r.hebergement) nbrh, h.description BestHebergement FROM App\Entity\Reservation r,App\Entity\Hebergement h WHERE r.hebergement=h.hebergementId GROUP by r.hebergement HAVING COUNT(r.hebergement) = ?1')
         ->setParameter(1,$q->getResult());
        return $query->getResult();
    }

//total prix 
public function tot()
{
    $em = $this->getEntityManager();
    $query=$em->createQuery(' SELECT SUM(h.prix+v.prix)  from App\Entity\Reservation r,App\Entity\Vol v,App\Entity\Hebergement h where v.volId = r.vol and r.hebergement = h.hebergementId ');
    return $query->getSingleScalarResult(); 
}




    public function cheap($x)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(r) FROM App\Entity\Reservation r, App\Entity\Vol v WHERE v.volId = r.vol and v.prix<?1 
        ')->setParameter(1,$x);
        return $query->getSingleScalarResult();
    }   

    public function expensive($x)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(r)  FROM App\Entity\Reservation r, App\Entity\Vol v WHERE v.volId = r.vol and v.prix>?1 
        ')->setParameter(1,$x);
        return $query->getSingleScalarResult();
    }   



}