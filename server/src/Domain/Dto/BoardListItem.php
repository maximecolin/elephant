<?php

namespace App\Domain\Dto;

class BoardListItem
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * BoardListItem constructor.
     *
     * @param int    $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
