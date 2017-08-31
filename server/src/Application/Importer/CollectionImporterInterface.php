<?php

namespace App\Application\Importer;

use App\Domain\Model\Collection;

interface CollectionImporterInterface
{
    /**
     * @param Collection $collection
     * @param string     $filename
     */
    public function import(Collection $collection, string $filename);
}
