<?php

namespace App\Application\Command\Board;

class UpdateBoardCommandHandler
{
    /**
     * @var UpdateBoardCommand $command
     */
    public function handle(UpdateBoardCommand $command)
    {
        $board = $command->board;
        $board->update($command->title);
    }
}

