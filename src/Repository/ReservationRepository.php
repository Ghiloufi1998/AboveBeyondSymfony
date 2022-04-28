<?php

namespace App\Repository;
use App\Entity\Facture;
use Doctrine\ORM\EntityRepository;
use App\Entity\Reservation;
use App\Entity\Hebergement;
use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reservation $entity, bool $flush = true): void
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
    public function remove(Reservation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return Reservation[] Returns an array of Reservation objects
     */
    public function showdetailVol()
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT vol.prix FROM App\Entity\Reservation AS rev, App\Entity\Vol as vol , App\Entity\Hebergement as heb WHERE rev.volId=vol.volId AND rev.hebergementId=heb.hebergementId ORDER BY rev.revId DESC  ")->setMaxResults(1);
        return $users = $query->getSingleScalarResult();
        

    } 
    public function showdetail()
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT vol.prix+heb.prix, rev.destination ,vol.prix,heb.prix,vol.depart,vol.image,heb.description,heb.image FROM App\Entity\Reservation AS rev, App\Entity\Vol as vol , App\Entity\Hebergement as heb WHERE rev.volId=vol.volId AND rev.hebergementId=heb.hebergementId ORDER BY rev.revId DESC  ")->setMaxResults(1);
        return $users = $query->execute();
        

    } 
    
    public function Montantfacture(int $prix){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Paiement   Set Montant =$prix ORDER BY Paiement.Pai_ID DESC LIMIT 1 ");
        return $users = $query->execute();
    } 
    
    public function showall()
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT vol.prix+heb.prix FROM App\Entity\Reservation AS rev, App\Entity\Vol as vol , App\Entity\Hebergement as heb WHERE rev.volId=vol.volId AND rev.hebergementId=heb.hebergementId ORDER BY rev.revId DESC  ")->setMaxResults(1);
        return $users = $query->getSingleScalarResult();
        

    } 
    public function payer(){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Facture,Reservation  Set Etat ='paye' ORDER BY Reservation.rev_Id DESC  LIMIT 1 ");
        return $users = $query->execute();
    } 
    public function facture(int $prix){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("INSERT Facture (Date_ech,Montant_ttc,Etat,rev_ID,Pai_ID) VALUES (Now(),'.$prix.','nonpayee',(select rev_ID from Reservation order by rev_ID desc LIMIT 1),(select Pai_ID from Paiement order by Pai_ID desc LIMIT 1)) ");
        return $users = $query->execute();
    } 
    public function Country(string $destination){
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT  vol.prix,vol.depart,vol.image from App\Entity\Vol as vol ,App\Entity\Hebergement as heb Where vol.destination='".$destination."'OR heb.adresse ='".$destination."'");
        return $users = $query->getResult();
    }  
    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
