<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questions::class);
    }

     /**
      * @return Questions[] Returns an array of Questions objects
      */
    
    public function findById($id)
    {
        return $this->createQueryBuilder('a')
            -> join ('a.sondage','c')
            ->addSelect ('c')
            ->andWhere('c.sondageId = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult()
        ;
    }
    
    

    
    public function findOneBySomeField($value): ?Questions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}