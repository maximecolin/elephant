<?php

namespace App\Application\Importer;

use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

interface CollectionImporterInterface
{
    /**
     * @param Collection    $collection
     * @param FileInterface $file
     */
    public function import(Collection $collection, FileInterface $file);

    /**
     * @param FileInterface $file
     *
     * @return bool
     */
    public function support(FileInterface $file) : bool;
}
