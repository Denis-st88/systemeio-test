<?php

declare(strict_types=1);

namespace App\V1\Api\Request\Product\Purchase;

use App\V1\Api\Request\Product\ApiRequest as CommonApiRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ApiRequest extends CommonApiRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $paymentProcessor;

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }
}
