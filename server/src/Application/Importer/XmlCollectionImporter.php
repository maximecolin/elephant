<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class XmlCollectionImporter implements CollectionImporterInterface
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
     * XmlCollectionImporter constructor.
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
        $document = new \SimpleXMLElement($file->getContent());

        foreach ($document->children() as $row) {
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
        return in_array($file->getMimeType(), ['text/xml', 'application/xml']);
    }
}
