<?php

declare(strict_types=1);

namespace App\Common\Controller;

use App\Common\Flow\FlowInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class Controller extends AbstractController
{
    public function index(FlowInterface $flow, HttpRequest $httpRequest): HttpResponse
    {
        return $flow->process($httpRequest);
    }
}
