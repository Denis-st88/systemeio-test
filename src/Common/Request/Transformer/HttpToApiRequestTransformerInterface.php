<?php

declare(strict_types=1);

namespace App\Common\Request\Transformer;

use App\Common\Request\ApiRequestInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

interface HttpToApiRequestTransformerInterface
{
    public function transform(HttpRequest $httpRequest): ApiRequestInterface;
}
