<?php

namespace App\Domain\Event;

use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use Symfony\Component\EventDispatcher\Event;

class CollaboratorAddedEvent extends Event
{
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * @var User
     */
    private $addedBy;

    /**
     * CollaboratorAddedEvent constructor.
     *
     * @param Collaborator $collaborator
     * @param User         $addedBy
     */
    public function __construct(Collaborator $collaborator, User $addedBy)
    {
        $this->collaborator = $collaborator;
        $this->addedBy = $addedBy;
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
     * Get addedBy
     *
     * @return User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }
}
