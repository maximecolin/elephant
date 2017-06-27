<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;

class UpdateBookmarkCommand
{
    /**
     * @var int
     */
    public $id;

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
     * UpdateBookmarkCommand constructor.
     *
     * @param int    $id
     * @param string $url
     * @param string $title
     * @param int    $collectionId
     */
    public function __construct(int $id, string $url, string $title, int $collectionId)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->collectionId = $collectionId;
    }

    /**
     * @param Bookmark $bookmark
     *
     * @return UpdateBookmarkCommand
     */
    public static function createFromBookmark(Bookmark $bookmark)
    {
        return new self($bookmark->getId(), $bookmark->getUrl(), $bookmark->getTitle(), $bookmark->getCollection()->getId());
    }
}
