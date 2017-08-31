<?php

namespace App\Application\Importer;

use App\Application\Exporter\Normalizer\BookmarkNormalizer;
use App\Domain\File\FileInterface;
use App\Domain\Model\Collection;

class XmlCollectionImporter implements CollectionImporterInterface
{
    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * XmlCollectionImporter constructor.
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
        $document = new \SimpleXMLElement($file->getContent());

        foreach ($document->children() as $row) {
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
        return in_array($file->getMimeType(), ['text/xml', 'application/xml']);
    }
}
