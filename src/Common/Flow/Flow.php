<?php

declare(strict_types=1);

namespace App\Common\Flow;

use League\Pipeline\PipelineInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

readonly class Flow implements FlowInterface
{
    public function __construct(private PipelineInterface $transitions)
    {
    }

    public function process(HttpRequest $httpRequest): HttpResponse
    {
        return ($this->transitions)($httpRequest);
    }
}
