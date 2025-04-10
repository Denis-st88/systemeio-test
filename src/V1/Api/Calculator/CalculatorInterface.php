<?php

declare(strict_types=1);

namespace App\V1\Api\Calculator;

use App\V1\Api\Stages\Product\Calculate\CalculatorDataInterface;

interface CalculatorInterface
{
    public function calculate(CalculatorDataInterface $data): float;
}
