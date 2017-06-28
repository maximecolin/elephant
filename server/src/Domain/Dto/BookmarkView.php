<?php

namespace App\Domain\Dto;

class BookmarkView
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
    public $url;

    /**
     * CollectionBookmarkView constructor.
     *
     * @param int    $id
     * @param string $title
     * @param string $url
     */
    public function __construct(int $id, string $title, string $url)
    {
        $this->id    = $id;
        $this->title = $title;
        $this->url   = $url;
    }
}
