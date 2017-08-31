<?php

namespace App\Application\Command\Collection;

use App\Application\Importer\CollectionImporter;
use App\Application\Importer\Format\FormatGuesserInterface;

class ImportCommandHandler
{
    /**
     * @var CollectionImporter
     */
    private $collectionImporter;

    /**
     * @var FormatGuesserInterface
     */
    private $formatGuesser;

    /**
     * ImportCommandHandler constructor.
     *
     * @param FormatGuesserInterface $formatGuesser
     * @param CollectionImporter     $collectionImporter
     */
    public function  __construct(FormatGuesserInterface $formatGuesser, CollectionImporter $collectionImporter)
    {
        $this->collectionImporter = $collectionImporter;
        $this->formatGuesser      = $formatGuesser;
    }

    /**
     * @var ImportCommand $command
     */
    public function handle(ImportCommand $command)
    {
        $format = $this->formatGuesser->guess($command->file);

        $this->collectionImporter->import($command->collection, $command->file->getPath(), $format);
    }
}
