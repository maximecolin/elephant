<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\Collection\ExportCommand;
use App\Domain\Dto\ExportedFile;
use App\Ui\Response\DownloadResponse;
use League\Tactician\CommandBus;

class ExportAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * ExportAction constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
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
        $command = new ExportCommand($collectionId, $boardId, $format);

        /** @var ExportedFile $file */
        $file = $this->commandBus->handle($command);

        return new DownloadResponse($file->filepath, $file->filename);
    }
}
