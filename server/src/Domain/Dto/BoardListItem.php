<?php

namespace App\Domain\Dto;

class BoardListItem
{
    /**
     * Board id
     *
     * @var int
     */
    public $id;

    /**
     * Board title
     *
     * @var string
     */
    public $title;

    /**
     * User current level
     *
     * @var string
     */
    public $level;

    /**
     * The number of collaborators
     *
     * @var int
     */
    public $collaborators;

    /**
     * The number of collections
     *
     * @var int
     */
    public $collections;

    /**
     * The number of bookmarks
     *
     * @var int
     */
    public $bookmarks;

    /**
     * BoardListItem constructor.
     *
     * @param int    $id
     * @param string $title
     * @param string $level
     * @param int    $collaborators
     * @param int    $collections
     * @param int    $bookmarks
     */
    public function __construct(int $id, string $title, string $level, int $collaborators, int $collections, int $bookmarks)
    {
        $this->id = $id;
        $this->title = $title;
        $this->level = $level;
        $this->collaborators = $collaborators;
        $this->collections = $collections;
        $this->bookmarks = $bookmarks;
    }
}
