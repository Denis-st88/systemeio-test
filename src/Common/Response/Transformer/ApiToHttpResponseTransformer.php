<?php

declare(strict_types=1);

namespace App\Common\Response\Transformer;

use App\Common\Response\ApiResponseInterface;
use League\Pipeline\StageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ApiToHttpResponseTransformer implements StageInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    /**
     * @param ApiResponseInterface $apiResponse
     */
    public function __invoke($apiResponse): HttpResponse
    {
        return $this->transform($apiResponse);
    }

    private function transform(ApiResponseInterface $apiResponse): HttpResponse
    {
        return new JsonResponse(
            $this->serializer->normalize($apiResponse, 'json')
        );
    }
}
