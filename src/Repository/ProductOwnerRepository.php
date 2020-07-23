<?php

namespace App\Repository;

use App\Entity\ProductOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductOwner|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOwner|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOwner[]    findAll()
 * @method ProductOwner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOwner::class);
    }

    // /**
    //  * @return ProductOwner[] Returns an array of ProductOwner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductOwner
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
