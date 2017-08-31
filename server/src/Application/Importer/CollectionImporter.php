<?php

namespace App\Application\Importer;

use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

class CollectionImporter
{
    /**
     * @var CollectionImporterInterface[]
     */
    private $importers = [];

    /**
     * CollectionImporter constructor.
     *
     * @param array $importers
     */
    public function __construct(array $importers)
    {
        foreach ($importers as $importer) {
            $this->register($importer);
        }
    }

    /**
     * @param Collection    $collection
     * @param FileInterface $file
     */
    public function import(Collection $collection, FileInterface $file)
    {
        foreach ($this->importers as $importer) {
            if ($importer->support($file)) {
                return $importer->import($collection, $file);
            }
        }

        throw new \LogicException('Importer not found');
    }

    /**
     * @param CollectionImporterInterface $importer
     *
     * @return $this
     */
    public function register(CollectionImporterInterface $importer)
    {
        $this->importers[] = $importer;

        return $this;
    }
}
