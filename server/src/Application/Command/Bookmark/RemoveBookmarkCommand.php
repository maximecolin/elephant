<?php

namespace App\Application\Command\Bookmark;

class RemoveBookmarkCommand
{
    /**
     * @var int
     */
    public $id;

    /**
     * RemoveBookmarkCommand constructor.
     *
     * @param int    $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
