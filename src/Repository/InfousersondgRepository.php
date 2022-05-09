<?php

namespace App\Repository;

use App\Entity\Infousersondg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Infousersondg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infousersondg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infousersondg[]    findAll()
 * @method Infousersondg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfousersondgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infousersondg::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Infousersondg $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Infousersondg $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Infousersondg[] Returns an array of Infousersondg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Infousersondg
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByFemme($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Infousersondg r JOIN r.sondage q WHERE r.sexe='Femme' and q.sondageId=:id")
            ->setParameter('id', $id)
          ;
        return $query->getResult();
     }

     public function findByHomme($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Infousersondg r JOIN r.sondage q WHERE r.sexe='Homme'  and q.questionId=:id")
            ->setParameter('id', $id)
          ;
        return $query->getResult();
     }
     public function findByAge($age){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT r FROM APP\Entity\Infousersondg r JOIN r.sondage q WHERE r.age=:age")
            ->setParameter('age', $age)
          ;
        return $query->getResult();}

        public function findByPay($pay){
            $entityManager=$this->getEntityManager();
            $query=$entityManager
                ->createQuery("SELECT r FROM APP\Entity\Infousersondg r JOIN r.sondage q WHERE r.pay=:pay")
                ->setParameter('pay', $pay)
              ;
            return $query->getResult();
      }
    
}
