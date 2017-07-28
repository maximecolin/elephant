<?php

namespace App\Application\Event;

use Symfony\Component\EventDispatcher\Event;

class EventRecorder implements EventRecorderInterface
{
    /**
     * @var array
     */
    private $events = [];

    /**
     * @param Event $event
     */
    public function record(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function release(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
    }
}
