<?php

namespace App\Application\Importer;

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
        foreach ($importers as $format => $importer) {
            $this->register($format, $importer);
        }
    }

    /**
     * @param Collection $collection
     * @param string     $filename
     * @param string     $format
     */
    public function import(Collection $collection, string $filename, string $format)
    {
        $this->getImporter($format)->import($collection, $filename);
    }

    /**
     * @param $format
     *
     * @return CollectionImporterInterface
     */
    public function getImporter($format) : CollectionImporterInterface
    {
        if (in_array($format, $this->getAvailableFormats())) {
            return $this->importers[$format];
        }

        throw new \LogicException('Importer not found');
    }

    /**
     * @param string                      $format
     * @param CollectionImporterInterface $importer
     *
     * @return $this
     */
    public function register(string $format, CollectionImporterInterface $importer)
    {
        $this->importers[$format] = $importer;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableFormats() : array
    {
        return array_keys($this->importers);
    }
}
