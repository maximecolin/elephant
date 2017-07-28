<?php

namespace App\Application\Event;

use Symfony\Component\EventDispatcher\Event;

interface EventRecorderInterface
{
    /**
     * @param $event
     */
    public function record(Event $event);

    /**
     * @return array
     */
    public function release() : array;
}
