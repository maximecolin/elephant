<?php

namespace App\Ui\Action\Collection;

use App\Application\Exporter\CollectionExporter;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Ui\Response\DownloadResponse;

class ExportAction
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var CollectionExporter
     */
    private $collectionExporter;

    /**
     * ExportAction constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CollectionExporter            $collectionExporter
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        CollectionExporter $collectionExporter
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->collectionExporter = $collectionExporter;
    }

    /**
     * @param int    $boardId
     * @param int    $collectionId
     * @param string $format
     *
     * @return DownloadResponse
     */
    public function __invoke(int $boardId, int $collectionId, string $format)
    {
        $collection = $this->collectionRepository->findOneById($collectionId, $boardId);
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'export' . uniqid();
        $this->collectionExporter->export($collection, $file, $format);
        $filename = sprintf('%s.%s', $collection->getTitle(), $format);

        return new DownloadResponse($file, $filename);
    }
}
