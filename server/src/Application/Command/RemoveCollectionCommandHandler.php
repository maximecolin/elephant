<?php

namespace App\Application\Command;

use App\Domain\Repository\CollectionRepositoryInterface;

class RemoveCollectionCommandHandler
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * RemoveCollectionCommandHandler constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     */
    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @param RemoveCollectionCommand $command
     */
    public function handle(RemoveCollectionCommand $command)
    {
        $collection = $this->collectionRepository->findOneById($command->id);
        $this->collectionRepository->remove($collection);
    }
}

