<?php

namespace App\Infrastructure\Tactician;

use App\Application\Event\EventRecorderInterface;
use League\Tactician\Middleware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RecordedEventsMiddleware implements Middleware
{
    /**
     * @var EventRecorderInterface
     */
    private $eventRecorder;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ProcessRecordedEventMiddleware constructor.
     *
     * @param EventRecorderInterface   $eventRecorder
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventRecorderInterface $eventRecorder, EventDispatcherInterface $eventDispatcher)
    {
        $this->eventRecorder = $eventRecorder;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command, callable $next)
    {
        $return = $next($command);

        foreach ($this->eventRecorder->release() as $event) {
            $this->eventDispatcher->dispatch(get_class($event), $event);
        }

        return $return;
    }
}
