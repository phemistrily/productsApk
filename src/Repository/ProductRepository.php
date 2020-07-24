<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private const LIMIT_ON_PAGE = 50;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findByEan13(string $ean13, bool $byFullString = false): array 
    {
        if(!$byFullString) {
            $ean13 = '%'.$ean13.'%';
        }
        $sql = $this->createQueryBuilder('p')
            ->where('p.bar_code_ean13 LIKE :ean13')
            ->orderBy('p.id', 'DESC')
            ->setParameter('ean13', $ean13)
            ;
        $query = $sql->getQuery();
        return $query->execute();
    }

    public function findNewest(int $page): array
    {
        $sql = $this->createQueryBuilder('p')
            ->setFirstResult(($page-1)*self::LIMIT_ON_PAGE)
            ->setMaxResults($page*self::LIMIT_ON_PAGE)
        ;
        $query = $sql->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
