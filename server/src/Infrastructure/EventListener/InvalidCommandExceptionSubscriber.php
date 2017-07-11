<?php

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Normalizer\InvalidCommandExceptionNormalizer;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class InvalidCommandExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var InvalidCommandExceptionNormalizer
     */
    private $normalizer;

    /**
     * InvalidCommandExceptionSubscriber constructor.
     */
    public function __construct()
    {
        $this->normalizer = new InvalidCommandExceptionNormalizer();
    }

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
            $event->setResponse(new JsonResponse($this->normalizer->normalize($exception)));
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
