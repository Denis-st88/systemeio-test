<?php

declare(strict_types=1);

namespace App\Common\Request;

use League\Pipeline\StageInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

readonly class HttpToApiRequestTransformer implements StageInterface
{
    public function __construct(
        private HttpToApiRequestTransformerInterface $httpToApiRequestTransformer
    ) {
    }

    /**
     * @param HttpRequest $httpRequest
     */
    public function __invoke($httpRequest): ApiRequestInterface
    {
        return $this->httpToApiRequestTransformer->transform($httpRequest);
    }
}
