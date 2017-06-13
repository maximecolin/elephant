<?php

namespace App\Application\Command;

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
     * CreateBookmarkCommand constructor.
     *
     * @param string $url
     * @param string $title
     */
    public function __construct(string $url, string $title)
    {
        $this->url = $url;
        $this->title = $title;
    }
}
