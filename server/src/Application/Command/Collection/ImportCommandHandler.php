<?php

namespace App\Application\Command\Collection;

use App\Application\Importer\CollectionImporter;

class ImportCommandHandler
{
    /**
     * @var CollectionImporter
     */
    private $collectionImporter;

    /**
     * ImportCommandHandler constructor.
     *
     * @param CollectionImporter     $collectionImporter
     */
    public function  __construct(CollectionImporter $collectionImporter)
    {
        $this->collectionImporter = $collectionImporter;
    }

    /**
     * @var ImportCommand $command
     */
    public function handle(ImportCommand $command)
    {
        $this->collectionImporter->import($command->collection, $command->file);
    }
}
