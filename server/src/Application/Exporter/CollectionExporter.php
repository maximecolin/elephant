<?php

namespace App\Application\Exporter;

use App\Domain\Model\Collection;

class CollectionExporter
{
    /**
     * @var CollectionExporterInterface[]
     */
    private $exporters = [];

    /**
     * CollectionExporter constructor.
     *
     * @param array $exporters
     */
    public function __construct(array $exporters)
    {
        foreach ($exporters as $format => $exporter) {
            $this->register($format, $exporter);
        }
    }

    /**
     * @param Collection $collection
     * @param string     $filename
     * @param string     $format
     *
     * @return string
     */
    public function export(Collection $collection, string $filename, string $format) : string
    {
        return $this->getExporter($format)->export($collection, $filename);
    }

    /**
     * @param $format
     *
     * @return CollectionExporterInterface
     */
    public function getExporter($format) : CollectionExporterInterface
    {
        if (in_array($format, $this->getAvailableFormats())) {
            return $this->exporters[$format];
        }

        throw new \LogicException('Exporter not found');
    }

    /**
     * @param string                      $format
     * @param CollectionExporterInterface $exporter
     *
     * @return $this
     */
    public function register(string $format, CollectionExporterInterface $exporter)
    {
        $this->exporters[$format] = $exporter;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableFormats() : array
    {
        return array_keys($this->exporters);
    }
}
