<?php

namespace App\Application\Command\Board;

class CreateBoardCommand
{
    /**
     * @var string
     */
    public $title;

    /**
     * CreateBoardCommand constructor.
     *
     * @param string $title
     */
    public function __construct(string $title = null)
    {
        $this->title = $title;
    }
}
