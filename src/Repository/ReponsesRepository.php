<?php

namespace App\Repository;

use App\Entity\Reponses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @method Reponses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reponses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reponses[]    findAll()
 * @method Reponses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponsesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponses::class);
    }

     /**
      * @return Reponses[] Returns an array of Sondage objects
      */

     public function findByQstId($id){
        return $this->createQueryBuilder('a')
        -> join ('a.question','c')
        ->addSelect ('c')
        ->andWhere('c.questionId = :val')
        ->setParameter('val', $id)
        ->getQuery()
        ->getArrayResult()
    ;
        ;
     }

      
    
     public function findByYes($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='YES/NO' and r.reponse='YES' and q.questionId=:id")
            ->setParameter('id', $id)
          ;
        return $query->getResult();
     }

     public function findByNo($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='YES/NO' and r.reponse='NO' and q.questionId=:id")
            ->setParameter('id', $id)
          ;
        return $query->getResult();
     }
     public function findByText($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Text' and q.questionId=:id")
            ->setParameter('id', $id)
          ;
        return $query->getResult();
     }

     public function findByStar1($id){
      $entityManager=$this->getEntityManager();
      $query=$entityManager
          ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Rate' and r.reponse='1.0' and q.questionId=:id")
          ->setParameter('id', $id)
        ;
      return $query->getResult();
   }

   public function findByStar2($id){
    $entityManager=$this->getEntityManager();
    $query=$entityManager
        ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Rate' and r.reponse='2.0' and q.questionId=:id")
        ->setParameter('id', $id)
      ;
    return $query->getResult();
 }

 public function findByStar3($id){
  $entityManager=$this->getEntityManager();
  $query=$entityManager
      ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Rate' and r.reponse='3.0' and q.questionId=:id")
      ->setParameter('id', $id)
    ;
  return $query->getResult();
}

public function findByStar4($id){
  $entityManager=$this->getEntityManager();
  $query=$entityManager
      ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Rate' and r.reponse='4.0' and q.questionId=:id")
      ->setParameter('id', $id)
    ;
  return $query->getResult();
}

public function findByStar5($id){
  $entityManager=$this->getEntityManager();
  $query=$entityManager
      ->createQuery("SELECT r FROM APP\Entity\Reponses r JOIN r.question q WHERE q.type='Rate' and r.reponse='5.0' and q.questionId=:id")
      ->setParameter('id', $id)
    ;
  return $query->getResult();
}




}