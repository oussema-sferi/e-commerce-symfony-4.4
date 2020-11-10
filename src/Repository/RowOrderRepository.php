<?php

namespace App\Repository;

use App\Entity\RowOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RowOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method RowOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method RowOrder[]    findAll()
 * @method RowOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RowOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RowOrder::class);
    }

    // /**
    //  * @return RowOrder[] Returns an array of RowOrder objects
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
    public function findOneBySomeField($value): ?RowOrder
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getRowOrderWhereProduct($id)
    {
        return $this->createQueryBuilder('r')
            ->join('r.product', 'p')
            ->where("p.id = $id")
            ->getQuery()
            ->getResult();
    }
}
