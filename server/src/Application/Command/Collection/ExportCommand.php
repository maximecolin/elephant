<?php

namespace App\Application\Command\Collection;

class ExportCommand
{
    /**
     * @var int
     */
    public $collectionId;

    /**
     * @var int
     */
    public $boardId;

    /**
     * @var string
     */
    public $format;

    /**
     * ExportCommand constructor.
     *
     * @param int    $collectionId
     * @param int    $boardId
     * @param string $format
     */
    public function __construct(int $collectionId, int $boardId, string $format)
    {
        $this->collectionId = $collectionId;
        $this->boardId      = $boardId;
        $this->format       = $format;
    }
}
