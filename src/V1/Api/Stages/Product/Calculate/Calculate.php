<?php

declare(strict_types=1);

namespace App\V1\Api\Stages\Product\Calculate;

use League\Pipeline\StageInterface;

class Calculate implements StageInterface
{
    /**
     * @param $payload
     */
    public function __invoke($payload)
    {
        // @TODO PROCESS
        dd($payload);
        die(__CLASS__);
    }
}
