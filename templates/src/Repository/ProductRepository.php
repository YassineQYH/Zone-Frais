<?php

namespace App\Repository;

use App\Entity\Category;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
    * @return Product[] Returns an array of Category and Gender objects
    */
    public function findAllOrderByCategory(Category $categoryProduit)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->leftJoin('p.category', 'c')
            ->andWhere('c = :category')
            ->setParameter('category', $categoryProduit)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
