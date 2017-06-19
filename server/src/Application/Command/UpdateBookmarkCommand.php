<?php

namespace App\Application\Command;

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
    private $collectionId;

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
}
