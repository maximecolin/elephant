<?php

namespace App\Infrastructure\EventListener;

use League\Tactician\Bundle\Middleware\InvalidCommandException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Validator\ConstraintViolationInterface;

class InvalidCommandExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * Handle InvalidCommandException thrown by Tactician command validation middleware on json request.
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $accepts = $event->getRequest()->getAcceptableContentTypes();

        if (in_array('application/json', $accepts) && $exception instanceof InvalidCommandException) {
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
