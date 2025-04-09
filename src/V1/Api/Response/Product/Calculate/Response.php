<?php

declare(strict_types=1);

namespace App\V1\Api\Response\Product\Calculate;

use App\Common\Response\ApiResponseInterface;

class Response implements ApiResponseInterface
{
    private float $price;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
