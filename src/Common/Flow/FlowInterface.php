<?php

declare(strict_types=1);

namespace App\Common\Flow;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

interface FlowInterface
{
    public function process(HttpRequest $httpRequest): HttpResponse;
}
