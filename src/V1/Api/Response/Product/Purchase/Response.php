<?php

declare(strict_types=1);

namespace App\V1\Api\Response\Product\Purchase;

use App\Common\Response\ApiResponseInterface;

class Response implements ApiResponseInterface
{
    private string $code;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
