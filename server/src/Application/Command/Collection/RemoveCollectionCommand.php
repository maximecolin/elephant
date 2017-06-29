<?php

namespace App\Application\Command\Collection;

class RemoveCollectionCommand
{
    /**
     * @var int
     */
    public $id;

    /**
     * RemoveCollectionCommand constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
