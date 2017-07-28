<?php

namespace App\Application\EventListener;

use App\Domain\Event\CollaboratorRemovedEvent;
use App\Domain\Mail\CollaboratorRemovedMailInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollaboratorRemovedEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var CollaboratorRemovedMailInterface
     */
    private $collaboratorRemovedMail;

    /**
     * CollaboratorRemovedEventSubscriber constructor.
     *
     * @param CollaboratorRemovedMailInterface $collaboratorRemovedMail
     */
    public function __construct(CollaboratorRemovedMailInterface $collaboratorRemovedMail)
    {
        $this->collaboratorRemovedMail = $collaboratorRemovedMail;
    }

    /**
     * @param CollaboratorRemovedEvent $event
     */
    public function onCollaboratorRemoved(CollaboratorRemovedEvent $event)
    {
        $this->collaboratorRemovedMail->send($event->getCollaborator(), $event->getRemovedBy());
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CollaboratorRemovedEvent::class => 'onCollaboratorRemoved',
        ];
    }
}
