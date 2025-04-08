<?php

declare(strict_types=1);

namespace App\Common\Flow;

use App\Common\Controller\ResponseInterface;
use League\Pipeline\PipelineInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

readonly class Flow implements FlowInterface
{
    public function __construct(private PipelineInterface $transitions)
    {
    }

    public function process(HttpRequest $httpRequest): ResponseInterface
    {
        return ($this->transitions)($httpRequest);
    }
}
