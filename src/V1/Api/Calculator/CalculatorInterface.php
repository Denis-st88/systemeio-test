<?php

declare(strict_types=1);

namespace App\V1\Api\Calculator;

interface CalculatorInterface
{
    public function calculate(
        int $price,
        float $taxRate,
        ?float $discount = null,
        ?string $discountType = null,
    ): int;
}
