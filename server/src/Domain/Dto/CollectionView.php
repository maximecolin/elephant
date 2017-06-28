<?php

namespace App\Domain\Dto;

class CollectionView
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
     * @var array
     */
    public $bookmarks;

    /**
     * CollectionView constructor.
     *
     * @param int    $id
     * @param string $title
     * @param array  $bookmarks
     */
    public function __construct(int $id, string $title, array $bookmarks)
    {
        $this->id        = $id;
        $this->title     = $title;
        $this->bookmarks = $bookmarks;
    }
}
