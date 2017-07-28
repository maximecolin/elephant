<?php

namespace App\Application\Command\Board;

use App\Domain\Model\User;

class RemoveCollaboratorCommand
{
    /**
     * @var int
     */
    public $boardId;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var User
     */
    public $removedBy;

    /**
     * RemoveCollaboratorCommand constructor.
     *
     * @param int  $boardId
     * @param int  $userId
     * @param User $removedBy
     */
    public function __construct(int $boardId, int $userId, User $removedBy)
    {
        $this->boardId = $boardId;
        $this->userId = $userId;
        $this->removedBy = $removedBy;
    }
}
