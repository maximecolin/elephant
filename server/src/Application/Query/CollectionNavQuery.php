<?php

namespace App\Application\Query;

class CollectionNavQuery
{
    /**
     * @var int
     */
    public $collectionId;

    /**
     * CollectionNavQuery constructor.
     *
     * @param int $collectionId
     */
    public function __construct(int $collectionId)
    {
        $this->collectionId = $collectionId;
    }
}
