<?php

declare(strict_types=1);

namespace App\V1\Infr\Events;

use App\Common\Exception\TransformFailedException;
use App\Common\Exception\ValidationException;
use App\V1\Api\Payment\PaymentProcessException;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    private const int BAD_REQUEST = 400;
    private const int UNPROCESSABLE_CONTENT = 422;
    private const int ENTITY_NOT_FOUND = 404;

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $data = match ($e::class) {
            ValidationException::class =>
                ['data' => ['errors' => $e->getErrors()], 'code' => self::BAD_REQUEST],
            TransformFailedException::class =>
                ['data' => ['errors' => $e->getErrors()], 'code' => self::UNPROCESSABLE_CONTENT],
            PaymentProcessException::class =>
                ['data' => ['message' => $e->getMessage()], 'code' => self::UNPROCESSABLE_CONTENT],
            EntityNotFoundException::class =>
                ['data' => ['message' => $e->getMessage()], 'code' => self::ENTITY_NOT_FOUND],
            default => []
        };

        if (!empty($data)) {
            $event->setResponse(
                (new JsonResponse())
                    ->setStatusCode($data['code'])
                    ->setData($data['data'])
            );
        }
    }
}
