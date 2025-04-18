<?php

declare(strict_types=1);

namespace App\V1\Api\Payment;

use App\V1\Api\Enum\PaymentType;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessAbstractFactory
{
    private PaymentProcessorInterface $paymentProcessor;

    public function __construct(string $type)
    {
        $this->paymentProcessor = match ($type) {
            PaymentType::Paypal->value => $this->getPaypalPaymentProcessor(),
            PaymentType::Stripe->value => $this->getStripePaymentProcessor(),
            default => throw new \LogicException(sprintf(
                'Unsupported payment processor type "%s"',
                $type
            )),
        };
    }

    public function create(): PaymentProcessorInterface
    {
        return $this->paymentProcessor;
    }

    private function getPaypalPaymentProcessor(): PaymentProcessorInterface
    {
        return new PaypalPaymentProcessorDecorator(
            new PaypalPaymentProcessor()
        );
    }

    private function getStripePaymentProcessor(): PaymentProcessorInterface
    {
        return new StripePaymentProcessorDecorator(
            new StripePaymentProcessor()
        );
    }
}
