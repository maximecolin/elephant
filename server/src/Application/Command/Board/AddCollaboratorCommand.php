<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Board;
use App\Domain\Model\User;

class AddCollaboratorCommand
{
    /**
     * @var Board
     */
    public $board;

    /**
     * @var User
     */
    public $user;

    /**
     * @var User
     */
    public $addedBy;

    /**
     * AddCollaboratorCommand constructor.
     *
     * @param Board $board
     * @param User  $addedBy
     */
    public function __construct(Board $board, User $addedBy)
    {
        $this->board = $board;
        $this->addedBy = $addedBy;
    }
}
