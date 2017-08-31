<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
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
    public function import(Collection $collection, FileInterface $file)
    {
        $file = new \SplFileObject($file->getPath(), 'r');

        while ($data = $file->fgetcsv(';')) {
            $bookmark = $this->normalizer->denormalize($data);
            $bookmark->moveTo($collection);

            $this->bookmarkRepository->add($bookmark);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(FileInterface $file) : bool
    {
        return 'text/csv' === $file->getMimeType();
    }
}
