<?php

declare(strict_types=1);

namespace App\V1\Api\Request;

use App\Common\Exception\TransformFailedException;
use App\Common\Request\ApiRequestInterface;
use App\Common\Request\Transformer\HttpToApiRequestTransformerInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class HttpRequestTransformer implements HttpToApiRequestTransformerInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private string              $type,
        private string              $format
    ) {
    }

    /**
     * @throws TransformFailedException
     */
    public function transform(HttpRequest $httpRequest): ApiRequestInterface
    {
        try {
            return $this->serializer->deserialize(
                $httpRequest->getContent(),
                $this->type,
                $this->format
            );
        } catch (ExceptionInterface $e) {
            throw new TransformFailedException(
                sprintf(
                    'An error was encountered during deserialization: %s',
                    $e->getMessage()
                )
            );
        }
    }
}
