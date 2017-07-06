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
     * AddCollaboratorCommand constructor.
     *
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }
}
