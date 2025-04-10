<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Tests\ApiTester;

trait HttpHeaderTrait
{
    public function _before(ApiTester $tester): void
    {
        $tester->haveHttpHeader('Content-Type', 'application/json');
    }
}
