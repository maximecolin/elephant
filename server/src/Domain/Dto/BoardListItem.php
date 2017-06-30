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
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $collaborators;

    /**
     * @var int
     */
    public $collections;

    /**
     * @var int
     */
    public $bookmarks;

    /**
     * BoardListItem constructor.
     *
     * @param int    $id
     * @param string $title
     * @param string $type
     * @param int    $collaborators
     * @param int    $collections
     * @param int    $bookmarks
     */
    public function __construct(int $id, string $title, string $type, int $collaborators, int $collections, int $bookmarks)
    {
        $this->id = $id;
        $this->title = $title;
        $this->type = $type;
        $this->collaborators = $collaborators;
        $this->collections = $collections;
        $this->bookmarks = $bookmarks;
    }
}
