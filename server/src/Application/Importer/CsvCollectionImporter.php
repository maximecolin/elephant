<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class CsvCollectionImporter implements CollectionImporterInterface
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * CsvCollectionImporter constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkNormalizer          $normalizer
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository, BookmarkNormalizer $normalizer)
    {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->normalizer         = $normalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function import(Collection $collection, string $filename)
    {
        $file = new \SplFileObject($filename, 'r');

        while ($data = $file->fgetcsv(';')) {
            $bookmark = $this->normalizer->denormalize($data);
            $bookmark->moveTo($collection);

            $this->bookmarkRepository->add($bookmark);
        }
    }
}
