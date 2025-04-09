<?php

declare(strict_types=1);

namespace App\V1\Infr\Events;

use App\Common\Exception\ValidationExceptionInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationExceptionInterface) {
            $response = new JsonResponse([
                'code' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ], 400);

            $event->setResponse($response);
        }

        if ($exception instanceof EntityNotFoundException) {
            $response = new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);

            $event->setResponse($response);
        }
    }
}
