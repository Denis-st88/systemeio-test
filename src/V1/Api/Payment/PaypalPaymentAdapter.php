<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

readonly class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(private PaypalPaymentProcessor $paypal)
    {
    }

    /**
     * @throws \Exception
     */
    public function pay(int $price): void
    {
        $this->paypal->pay($price);
    }
}
