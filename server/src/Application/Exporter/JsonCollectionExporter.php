<?php

namespace App\Application\Exporter;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class JsonCollectionExporter implements CollectionExporterInterface
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var BookmarkNormalizer
     */
    private $bookmarkNormalizer;

    /**
     * JsonCollectionExporter constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param BookmarkNormalizer          $bookmarkNormalizer
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        BookmarkNormalizer $bookmarkNormalizer
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->bookmarkNormalizer = $bookmarkNormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function export(Collection $collection, string $filename)
    {
        $bookmarks = $this->bookmarkRepository->findByCollection($collection);
        $data = array_map([$this->bookmarkNormalizer, 'normalize'], $bookmarks);

        file_put_contents($filename, json_encode($data));

        return $filename;
    }
}
