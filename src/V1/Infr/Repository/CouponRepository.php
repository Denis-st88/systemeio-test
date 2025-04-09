<?php

declare(strict_types=1);

namespace App\V1\Infr\Repository;

use App\V1\Domain\Coupon;
use App\V1\Domain\Repository\CouponRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CouponRepository extends ServiceEntityRepository implements CouponRepositoryInterface
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Coupon::class);
    }

    public function findByCodeAndDiscount(string $code, float $discount): ?Coupon
    {
        return $this->createQueryBuilder('coupon')
            ->where('coupon.code = :code')
            ->andWhere('coupon.discount = :discount')
            ->setParameter('code', $code)
            ->setParameter('discount', $discount)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
