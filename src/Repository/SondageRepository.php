<?php

namespace App\Repository;

//use App\Entity\SearchData;
use App\Entity\Sondage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @method Sondage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sondage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sondage[]    findAll()
 * @method Sondage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SondageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sondage::class);
    
    }


     /**
      * @return Sondage[] Returns an array of Sondage objects
      */

     
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function findOneBySomeField($value): ?Sondage
    {
        return $this->createQueryBuilder('nbr')
        -> join ('nbr.Question','c')
        ->addSelect ('c')
        ->andWhere('c.sondageId = :val')
        ->setParameter('val', $id)
        ->getQuery()
        ->getArrayResult()
    ;
        ;
    }

    public function findByNbrRep():?sondage
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT count(nbr) FROM APP\Entity\sondage and APP\Entity\Questions and APP\Entity\Reponses WHERE réponses.Question_id=questions.Question_id and questions.sondage_id=sondage.sondage_id GROUP BY sondage.sujet")
          ;
        return $query->getResult();
    }

    /**
     * @return Sondage[]
     *
     */

    public function findBySearch($search,$sond): ?Sondage
    {
        $query= $this->createQueryBuilder('s');
        //$query->where('s.active=1');

        if(!empty($search)){
            $query=$query
            ->andWhere('s.sujet= :val')
            ->setParameter('val', "%{$search}%");
        }

        if(!empty($sond)){
            $query=$query
            ->andWhere('s.categorie= :val1')
            ->setParameter('val1', $sond);
        }
       
       return $query->getQuery->getArrayResult();
    }
}