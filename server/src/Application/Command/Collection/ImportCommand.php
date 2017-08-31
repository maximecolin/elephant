<?php

namespace App\Application\Command\Collection;

use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

class ImportCommand
{
    /**
     * @var Collection
     */
    public $collection;

    /**
     * @var FileInterface
     */
    public $file;

    /**
     * ImportCommand constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }
}
