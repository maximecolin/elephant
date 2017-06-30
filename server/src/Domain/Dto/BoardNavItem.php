<?php

namespace App\Domain\Dto;

class BoardNavItem
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
     * BoardNavItem constructor.
     *
     * @param int    $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id    = $id;
        $this->title = $title;
    }
}
