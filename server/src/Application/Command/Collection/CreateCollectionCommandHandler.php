<?php

namespace App\Application\Command\Collection;

use App\Domain\Model\Collection;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Collection\UniqueTitleChecker;

class CreateCollectionCommandHandler
{
    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

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
     * @param BoardRepositoryInterface      $boardRepository
     * @param CollectionRepositoryInterface $collectionRepository
     * @param UniqueTitleChecker            $uniqueTitleChecker
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        CollectionRepositoryInterface $collectionRepository,
        UniqueTitleChecker $uniqueTitleChecker
    ) {
        $this->boardRepository = $boardRepository;
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
        $board = $this->boardRepository->findOneById($command->boardId);

        $collection = new Collection($board, $command->title);

        $this->uniqueTitleChecker->check($collection);
        $this->collectionRepository->add($collection);

        return $collection;
    }
}

