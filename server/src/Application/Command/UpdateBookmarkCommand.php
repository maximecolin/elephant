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
     * UpdateBookmarkCommand constructor.
     *
     * @param int    $id
     * @param string $url
     * @param string $title
     */
    public function __construct(int $id, string $url, string $title)
    {
        $this->id = $id;
        $this->url = $url;
        $this->title = $title;
    }
}
