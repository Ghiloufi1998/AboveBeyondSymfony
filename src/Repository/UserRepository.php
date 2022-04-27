<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

  
    
    public function findByDate()
    {
        return $this->createQueryBuilder('User')
            ->orderBy('User.birthday','DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByDate2()
    {
        return $this->createQueryBuilder('User')
            ->orderBy('User.birthday','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMale()
    {
        return $this->createQueryBuilder('User')
            ->where('User.gender Like :gender')
            ->setParameter('gender', '%Male%')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findFemale()
    {
        return $this->createQueryBuilder('User')
            ->where('User.gender Like :gender')
            ->setParameter('gender', '%Female%')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
