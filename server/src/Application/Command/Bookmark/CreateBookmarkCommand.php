<?php

namespace App\Application\Command\Bookmark;

class CreateBookmarkCommand
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $collectionId;

    /**
     * CreateBookmarkCommand constructor.
     *
     * @param string $url
     * @param string $title
     * @param int    $collectionId
     */
    public function __construct(string $url = null, string $title = null, int $collectionId = null)
    {
        $this->url = $url;
        $this->title = $title;
        $this->collectionId = $collectionId;
    }
}
