<?php

namespace App\Application\Command;

class CreateCollectionCommand
{
    /**
     * @var string
     */
    public $title;

    /**
     * CreateCollectionCommand constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }
}
