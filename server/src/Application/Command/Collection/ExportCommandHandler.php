<?php

namespace App\Application\Command\Collection;

use App\Application\Exporter\CollectionExporter;
use App\Domain\Dto\ExportedFile;
use App\Domain\Repository\CollectionRepositoryInterface;

class ExportCommandHandler
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
     * @var ExportCommand $command
     *
     * @return ExportedFile
     */
    public function handle(ExportCommand $command) : ExportedFile
    {
        $collection = $this->collectionRepository->findOneById($command->collectionId, $command->boardId);
        $filepath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'export' . uniqid();
        $this->collectionExporter->export($collection, $filepath, $command->format);
        $filename = sprintf('%s.%s', $collection->getTitle(), $command->format);

        return new ExportedFile($filepath, $filename);
    }
}
