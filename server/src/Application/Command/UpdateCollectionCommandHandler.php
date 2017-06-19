<?php

namespace App\Application\Command;

use App\Domain\Model\Collection;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Collection\UniqueTitleChecker;

class UpdateCollectionCommandHandler
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var UniqueTitleChecker
     */
    private $uniqueTitleChecker;

    /**
     * UpdateCollectionCommandHandler constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param UniqueTitleChecker            $uniqueTitleChecker
     */
    public function __construct(CollectionRepositoryInterface $collectionRepository, UniqueTitleChecker $uniqueTitleChecker)
    {
        $this->collectionRepository = $collectionRepository;
        $this->uniqueTitleChecker = $uniqueTitleChecker;
    }

    /**
     * @param UpdateCollectionCommand $command
     *
     * @return Collection
     */
    public function handle(UpdateCollectionCommand $command)
    {
        $collection = $this->collectionRepository->findOneById($command->id);
        $collection->update($command->title);

        $this->uniqueTitleChecker->check($collection);

        return $collection;
    }
}

