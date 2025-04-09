<?php

declare(strict_types=1);

namespace App\V1\Infr\Repository;

use App\V1\Domain\Product;
use App\V1\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Product::class);
    }

    public function getProductById(int $id): Product
    {
        try {
            return $this->createQueryBuilder('product')
                ->where('product.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (ORMException $e) {
            throw new EntityNotFoundException(sprintf(
                'Product entity id "%s" not found.',
                $id
            ));
        }
    }
}
