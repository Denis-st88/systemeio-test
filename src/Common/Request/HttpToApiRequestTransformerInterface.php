<?php

declare(strict_types=1);

namespace App\Common\Request;

use Symfony\Component\HttpFoundation\Request as HttpRequest;

interface HttpToApiRequestTransformerInterface
{
    public function transform(HttpRequest $httpRequest): ApiRequestInterface;
}
