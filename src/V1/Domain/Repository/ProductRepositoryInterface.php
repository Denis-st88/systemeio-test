<?php

declare(strict_types=1);

namespace App\V1\Domain\Repository;

use App\V1\Domain\Product;

interface ProductRepositoryInterface
{
    public function getProductById(int $id): Product;
}
