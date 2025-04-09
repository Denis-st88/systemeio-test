<?php

declare(strict_types=1);

namespace App\V1\Domain\Repository;

use App\V1\Domain\Coupon;

interface CouponRepositoryInterface
{
    public function findByCodeAndDiscount(string $code, float $discount): ?Coupon;
}
