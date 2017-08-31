<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class JsonCollectionImporter implements CollectionImporterInterface
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
     * JsonCollectionImporter constructor.
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
        $rows = json_decode($file->getContent(), true);

        foreach ($rows as $row) {
            $bookmark = $this->normalizer->denormalize($row);
            $bookmark->moveTo($collection);

            $this->bookmarkRepository->add($bookmark);
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
