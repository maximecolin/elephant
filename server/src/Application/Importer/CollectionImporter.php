<?php

namespace App\Application\Importer;

use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class CollectionImporter
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var CollectionImporterInterface[]
     */
    private $importers = [];

    /**
     * CollectionImporter constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param array                       $importers
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository, array $importers)
    {
        $this->bookmarkRepository = $bookmarkRepository;

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
                foreach ($importer->import($collection, $file) as $bookmark) {
                    $this->bookmarkRepository->add($bookmark);
                }

                return;
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
