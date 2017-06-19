<?php

namespace App\Infrastructure\EventListener;

use League\Tactician\Bundle\Middleware\InvalidCommandException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof InvalidCommandException) {
            $event->setResponse(new JsonResponse([
                'errors' => array_map(function (ConstraintViolationInterface $violation) {
                    return [
                        'message' => $violation->getMessage(),
                        'path' => $violation->getPropertyPath(),
                    ];
                 }, iterator_to_array($exception->getViolations()))
            ]));
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
