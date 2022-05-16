<?php

namespace App\Repository;

use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vol|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vol|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vol[]    findAll()
 * @method Vol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Vol $entity, bool $flush = true): void
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
    public function remove(Vol $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
 /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    
    public function findBydestination($value): ?vol
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery("Select distinct V from App\Entity\Vol V  where V.destination=".$value);
        if ($flush) {
            return  $query->getResult();
        }
      
        
    }


    
    public function findOneByImage($value): ?string
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager->createQuery('Select  from App\Entity\reservation r, App\Entity\Vol v where r.vol_ID=v.Vol_id  Order by r.rev_ID Desc Limit 1;');
        return  $query->getResult();
    }
    
}
//return $this->createQueryBuilder('v')
//->Join('Reservation.rev_ID','R')
//->addOrderBy('Reservation.rev_ID', 'Desc')
//->setMaxResults($value)
//->getQuery()
//->getResult()
//;