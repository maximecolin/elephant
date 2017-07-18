<?php

namespace App\Application\Exporter;

use App\Domain\Model\Collection;

interface CollectionExporterInterface
{
    public function export(Collection $collection, string $filename);
}
