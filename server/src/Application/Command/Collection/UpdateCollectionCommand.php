<?php

namespace App\Application\Command\Collection;

use App\Domain\Model\Collection;

class UpdateCollectionCommand
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * UpdateCollectionCommand constructor.
     *
     * @param int    $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @param Collection $collection
     *
     * @return UpdateCollectionCommand
     */
    public static function createFromCollection(Collection $collection)
    {
        return new self($collection->getId(), $collection->getTitle());
    }
}
