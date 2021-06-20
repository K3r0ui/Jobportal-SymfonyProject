<?php

namespace App\Repository;

use App\Entity\Demploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Demploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demploi[]    findAll()
 * @method Demploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demploi::class);
    }
     /**
     * @return Demploi[] Returns an array of Demploi objects
     */
    
    public function findByExampleField($value , $value2)
    {
        return $this->createQueryBuilder('Demploi')
         
            ->where("Demploi.oemploi = :id")
            ->andWhere("Demploi.idcondidat = :id1")
           /* ->andWhere('d.exampleField = :val')*/
            ->setParameter('id', $value)
            ->setParameter('id1', $value2)
        /*    ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)*/
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Demploi[] Returns an array of Demploi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Demploi
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
