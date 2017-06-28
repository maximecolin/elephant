<?php

namespace App\Infrastructure\EventListener;

use App\Domain\Exception\ModelNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModelNotFoundExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * ModelNotFoundException => 404
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof ModelNotFoundException) {
            throw new NotFoundHttpException($exception->getMessage(), $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
