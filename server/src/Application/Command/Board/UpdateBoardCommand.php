<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Board;

class UpdateBoardCommand
{
    /**
     * @var Board
     */
    public $board;

    /**
     * @var string
     */
    public $title;

    /**
     * UpdateBoardCommand constructor.
     *
     * @param Board  $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->title = $board->getTitle();
    }
}
