<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

class CsvCollectionImporter implements CollectionImporterInterface
{
    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * CsvCollectionImporter constructor.
     *
     * @param BookmarkNormalizer $normalizer
     */
    public function __construct(BookmarkNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
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

            yield $bookmark;
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
