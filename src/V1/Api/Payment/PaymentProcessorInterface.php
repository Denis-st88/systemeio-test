<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

interface PaymentProcessorInterface
{
    /**
     * @throws PaymentProcessException
     */
    public function pay(float $price): void;
}
