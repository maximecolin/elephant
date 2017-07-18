<?php

namespace App\Application\Exporter;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class CsvCollectionExporter implements CollectionExporterInterface
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
     * CsvCollectionExporter constructor.
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
     * @param Collection $collection
     * @param string     $filename
     *
     * @return string
     */
    public function export(Collection $collection, string $filename)
    {
        $bookmarks = $this->bookmarkRepository->findByCollection($collection);

        $file = new \SplFileObject($filename, 'w');

        foreach ($bookmarks as $bookmark) {
            $file->fputcsv($this->bookmarkNormalizer->normalize($bookmark), ';');
        }

        return $filename;
    }
}
