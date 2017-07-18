<?php

namespace App\Application\Exporter;

use App\Domain\Model\Collection;
use App\Domain\Repository\BookmarkRepositoryInterface;

class XmlCollectionExporter implements CollectionExporterInterface
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * XmlCollectionExporter constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function export(Collection $collection, string $filename)
    {
        $bookmarks = $this->bookmarkRepository->findByCollection($collection);

        $document = new \SimpleXMLElement('<collection></collection>');

        foreach ($bookmarks as $bookmark) {
            $child = $document->addChild('bookmark');
            $child->addChild('title', $bookmark->getTitle());
            $child->addChild('url', $bookmark->getUrl());
        }

        $document->saveXML($filename);

        return $filename;
    }
}
