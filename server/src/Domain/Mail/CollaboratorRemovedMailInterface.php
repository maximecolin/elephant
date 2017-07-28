<?php

namespace App\Domain\Mail;

use App\Domain\Model\Collaborator;
use App\Domain\Model\User;

interface CollaboratorRemovedMailInterface
{
    /**
     * @param Collaborator $collaborator
     * @param User         $addedBy
     */
    public function send(Collaborator $collaborator, User $addedBy);
}
