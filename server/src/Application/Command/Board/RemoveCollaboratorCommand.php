<?php

namespace App\Application\Command\Board;

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
     * RemoveCollaboratorCommand constructor.
     *
     * @param int $boardId
     * @param int $userId
     */
    public function __construct(int $boardId, int $userId)
    {
        $this->boardId = $boardId;
        $this->userId = $userId;
    }
}
