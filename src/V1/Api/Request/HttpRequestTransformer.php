<?php

declare(strict_types=1);

namespace App\V1\Api\Request;

use App\Common\Exception\TransformFailedException;
use App\Common\Exception\ValidationException;
use App\Common\Request\ApiRequestInterface;
use App\Common\Request\Transformer\HttpToApiRequestTransformerInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
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
     * @throws ValidationException
     */
    public function transform(HttpRequest $httpRequest): ApiRequestInterface
    {
        try {
            return $this->serializer->deserialize(
                $httpRequest->getContent(),
                $this->type,
                $this->format
            );
        } catch (NotNormalizableValueException $e) {
            $errors[] = [
                'field' => $e->getPath(),
                'message' => sprintf(
                    'The type of the "%s" must be one of types "%s" (%s given)',
                    $e->getPath(),
                    implode(', ', $e->getExpectedTypes() ?? []),
                    $e->getCurrentType()
                )
            ];

            throw (new ValidationException())->setErrors($errors);
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
