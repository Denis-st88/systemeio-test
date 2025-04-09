<?php

declare(strict_types=1);

namespace App\Common\Flow;

use App\Common\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

interface FlowInterface
{
    public function process(HttpRequest $httpRequest): ResponseInterface;
}
