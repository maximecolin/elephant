<?php

namespace App\Domain\Event;

use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use Symfony\Component\EventDispatcher\Event;

class CollaboratorRemovedEvent extends Event
{
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * @var User
     */
    private $removedBy;

    /**
     * CollaboratorRemovedEvent constructor.
     *
     * @param Collaborator $collaborator
     * @param User         $removedBy
     */
    public function __construct(Collaborator $collaborator, User $removedBy)
    {
        $this->collaborator = $collaborator;
        $this->removedBy = $removedBy;
    }

    /**
     * Get collaborator
     *
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }

    /**
     * Get removedBy
     *
     * @return User
     */
    public function getRemovedBy()
    {
        return $this->removedBy;
    }
}
