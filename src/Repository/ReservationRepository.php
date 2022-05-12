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
    public function findByuser($val)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery('select r from App\Entity\Reservation r, App\Entity\User u where r.idUser = u.id and u.id= ?1 ')
        ->setParameter(1,$val);
        return $query->getResult();   
    }

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



// fin iheb 
//debut amine
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
    public function showdetailVol($Reservation)
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT v.prix FROM App\Entity\Reservation AS r, App\Entity\Vol as v , App\Entity\Hebergement as h WHERE r.vol=v.volId AND r.hebergement = h.hebergementId AND r.revId= ?1")
        ->setParameter(1,$Reservation);
        return $users = $query->getSingleScalarResult();
        

    } 
    public function showdetail($Reservation)
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT v.prix+h.prix, r.destination ,v.prix,h.prix,v.depart,v.image,h.description,h.image FROM App\Entity\Reservation AS r, App\Entity\Vol as v , App\Entity\Hebergement as h WHERE r.vol=v.volId AND r.hebergement=h.hebergementId AND r.revId= ?1")
        ->setParameter(1,$Reservation);
        return $users = $query->execute();
        

    } 
    
    public function Montantfacture($prix){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Paiement  Set Montant =$prix ORDER BY Paiement.Pai_ID DESC LIMIT 1 ");
        return $users = $query->execute();
    } 
    
    public function showall($Reservation)
    { 
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT v.prix+h.prix  FROM App\Entity\Reservation AS r, App\Entity\Vol as v, App\Entity\Hebergement as h WHERE v.volId = r.vol AND r.hebergement=h.hebergementId AND r.revId=?1  ")
        ->setParameter(1,$Reservation);
        return $users = $query->getSingleScalarResult();
    } 
    /*public function payer(){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Facture,Reservation  Set Etat ='paye' ORDER BY Reservation.rev_Id DESC  LIMIT 1 ");
        return $users = $query->execute();
    } */
    public function payer($Reservation){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Facture Set Etat ='paye' where rev_ID= 105");
        return $users = $query->execute();
    } 
    public function facture($prix){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("INSERT Facture (Date_ech,Montant_ttc,Etat,rev_ID,Pai_ID) VALUES (Now(),'.$prix.','nonpayee',(select rev_ID from Reservation order by rev_ID desc LIMIT 1),(select Pai_ID from Paiement order by Pai_ID desc LIMIT 1)) ");
        return $users = $query->execute();
    } 
    public function Country($destination){
        $Em=$this->getEntityManager();
        $query=$Em->createQuery("SELECT  vol.prix,vol.depart,vol.image from App\Entity\Vol as vol ,App\Entity\Hebergement as heb Where vol.destination='".$destination."'OR heb.adresse ='".$destination."'");
        return $users = $query->getResult();
    }  

    public function useroff($destination){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE facture set facture.Montant_ttc = ( facture.Montant_ttc - (facture.Montant_ttc*( select offres.Pourcentage_red from reservation,offres,user,facture WHERE reservation.rev_ID=facture.rev_ID and offres.ID_off=user.id_offre and reservation.ID_user=user.id) /100)) WHERE facture.ID_fac=(select facture.ID_fac from reservation,offres,user,facture WHERE reservation.rev_ID=facture.rev_ID and offres.ID_off=user.id_offre and reservation.ID_user=user.id and user.id =14 and UPPER('Ukraine')=UPPER(reservation.Destination));
        ");
        return $users = $query->execute();
    } 
    public function montantoffr(){
        $Em=$this->getEntityManager();
        //SELECT f.Montant_ttc from Facture as f, Reservation AS rev, User as u where 
        $query=$Em->createQuery("SELECT Distinct f.montantTtc from App\Entity\Facture as f, App\Entity\Reservation AS rev, App\Entity\User as u where rev.revId=f.rev and rev.idUser=14");
        return $users = $query->getSingleScalarResult();
    } 
    

    public function MontantPaiement(){
        $Em=$this->getEntityManager();
        $query=$Em->getConnection()->prepare("UPDATE Paiement  Set Montant =$prix ORDER BY Paiement.Pai_ID where facture.Pai_ID=Paiement.Pai_ID and facture.rev_ID=reservation.rev_ID and reservation.ID_user=user.id=14 ");
        return $users = $query->execute();
    } 
 
   
}