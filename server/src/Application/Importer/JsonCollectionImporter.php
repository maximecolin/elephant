<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

class JsonCollectionImporter implements CollectionImporterInterface
{
    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * JsonCollectionImporter constructor.
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
        $rows = json_decode($file->getContent(), true);

        foreach ($rows as $row) {
            $bookmark = $this->normalizer->denormalize($row);
            $bookmark->moveTo($collection);

            yield $bookmark;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function support(FileInterface $file) : bool
    {
        return 'application/json' === $file->getMimeType();
    }
}
