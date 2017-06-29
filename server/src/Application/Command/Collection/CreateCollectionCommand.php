<?php

namespace App\Application\Command\Collection;

class CreateCollectionCommand
{
    /**
     * @var int
     */
    public $boardId;

    /**
     * @var string
     */
    public $title;

    /**
     * CreateCollectionCommand constructor.
     *
     * @param int    $boardId
     * @param string $title
     */
    public function __construct(int $boardId, string $title = null)
    {
        $this->title = $title;
        $this->boardId = $boardId;
    }
}
