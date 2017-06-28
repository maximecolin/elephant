<?php

namespace App\Application\Query;

class CollectionViewQuery
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $offset;

    /**
     * @var int
     */
    public $limit;

    /**
     * CollectionViewQuery constructor.
     *
     * @param int $id
     * @param int $offset
     * @param int $limit
     */
    public function __construct(int $id, int $offset = 0, int $limit = 100)
    {
        $this->id = $id;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
