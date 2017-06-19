<?php

namespace App\Application\Command;

use App\Domain\Model\Collection;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Collection\UniqueTitleChecker;

class CreateCollectionCommandHandler
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
     * CreateCollectionCommandHandler constructor.
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
     * @param CreateCollectionCommand $command
     *
     * @return Collection
     */
    public function handle(CreateCollectionCommand $command)
    {
        $collection = new Collection($command->title);

        $this->uniqueTitleChecker->check($collection);
        $this->collectionRepository->add($collection);

        return $collection;
    }
}

