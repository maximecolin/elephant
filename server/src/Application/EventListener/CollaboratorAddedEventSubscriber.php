<?php

namespace App\Application\EventListener;

use App\Domain\Event\CollaboratorAddedEvent;
use App\Domain\Mail\CollaboratorAddedMailInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollaboratorAddedEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var CollaboratorAddedMailInterface
     */
    private $collaboratorAddedMail;

    /**
     * CollaboratorAddedEventSubscriber constructor.
     *
     * @param CollaboratorAddedMailInterface $collaboratorAddedMail
     */
    public function __construct(CollaboratorAddedMailInterface $collaboratorAddedMail)
    {
        $this->collaboratorAddedMail = $collaboratorAddedMail;
    }

    /**
     * @param CollaboratorAddedEvent $event
     */
    public function onCollaboratorAdded(CollaboratorAddedEvent $event)
    {
        $this->collaboratorAddedMail->send($event->getCollaborator(), $event->getAddedBy());
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CollaboratorAddedEvent::class => 'onCollaboratorAdded',
        ];
    }
}
