<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }
    public function findByReclamation()
    {
        return $this->createQueryBuilder('Reclamation')
            ->orderBy('Reclamation.date','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByReclamation2()
    {
        return $this->createQueryBuilder('Reclamation')
            ->orderBy('Reclamation.date','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByReclUser($val)
    {
        return $this->createQueryBuilder('Reclamation')
            ->andWhere('Reclamation.user = :val')
            ->setParameter('val', $val)
            ->orderBy('Reclamation.date','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByReclUser2($val)
    {
        return $this->createQueryBuilder('Reclamation')
            ->andWhere('Reclamation.user = :val')
            ->setParameter('val', $val)
            ->orderBy('Reclamation.date','ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Reclamation[] Returns an array of Reclamation objects
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
    public function findOneBySomeField($value): ?Reclamation
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
