<?php

namespace App\Repository;

use App\Entity\Oemploi;
use App\Data\SearchData;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Oemploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oemploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oemploi[]    findAll()
 * @method Oemploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OemploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginates)
    {
        parent::__construct($registry, Oemploi::class);
        $this->paginates = $paginates;
    }

    // /**
    //  * @return Oemploi[] Returns an array of Oemploi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Oemploi
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface {

            
        $query=$this->SearchQ($search)->getQuery();
        return $this->paginates->paginate(
            $query,
            $search->page,
            2
        );
    }
    /**
     * recuperation du salaire minimum et maximale
     * @param SearchData $search
     * @return integer[]
     */
    public function findMinMax(SearchData $search):array {
        $rslt = $this->SearchQ($search,true)
        ->select('MIN(om.salaire) as min, Max(om.salaire) as max')
        ->getQuery()
        ->getScalarResult();
      return [(int)$rslt[0]['min'],(int)$rslt[0]['max']];
    }
    public function SearchQ(SearchData $search, $ignsalaire = false): QueryBuilder{
        $query = $this
        ->createQueryBuilder('om')
        ->select('c','om')
        ->join('om.categorie','c');
        if(!empty($search->q)){
            $query=$query
            ->andwhere('om.title LIKE :q')
            ->setParameter('q',"%{$search->q}%");
        }
        if(!empty($search->min) && $ignsalaire === false){
         $query=$query
         ->andwhere('om.salaire >= :min')
         ->setParameter('min',$search->min);
     }
     if(!empty($search->max) && $ignsalaire === false){
         $query=$query
         ->andwhere('om.salaire <= :max')
         ->setParameter('max',$search->max);
     }
     if(!empty($search->categories)){
         $query=$query
         ->andwhere('c.id IN (:categories)')
         ->setParameter('categories',$search->categories);
     }return $query;
    }

}
