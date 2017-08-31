<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
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
    public function import(Collection $collection, string $filename)
    {
        $rows = json_decode(file_get_contents($filename), true);

        dump($filename, file_get_contents($filename), $rows);

        foreach ($rows as $row) {
            $bookmark = $this->normalizer->denormalize($row);
            $bookmark->moveTo($collection);

            $this->bookmarkRepository->add($bookmark);
        }
    }
}
