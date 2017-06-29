<?php

namespace App\Application\Query;

class CollectionNavQuery
{
    /**
     * @var int
     */
    public $boardId;

    /**
     * @var int
     */
    public $collectionId;

    /**
     * CollectionNavQuery constructor.
     *
     * @param int $boardId
     * @param int $collectionId
     */
    public function __construct(int $boardId, int $collectionId)
    {
        $this->collectionId = $collectionId;
        $this->boardId = $boardId;
    }
}
