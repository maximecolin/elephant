<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Bookmark\UniqueUrlChecker;

class CreateBookmarkCommandHandler
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var UniqueUrlChecker
     */
    private $uniqueUrlChecker;

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * CreateBookmarkCommandHandler constructor.
     *
     * @param BookmarkRepositoryInterface   $bookmarkRepository
     * @param CollectionRepositoryInterface $collectionRepository
     * @param UniqueUrlChecker              $uniqueUrlChecker
     */
    public function __construct(
        BookmarkRepositoryInterface $bookmarkRepository,
        CollectionRepositoryInterface $collectionRepository,
        UniqueUrlChecker $uniqueUrlChecker
    ) {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->uniqueUrlChecker = $uniqueUrlChecker;
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @param CreateBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(CreateBookmarkCommand $command)
    {
        $collection = $this->collectionRepository->findOneById($command->collectionId);
        $bookmark = new Bookmark($command->url, $command->title, $collection);

        $this->uniqueUrlChecker->check($bookmark);
        $this->bookmarkRepository->add($bookmark);

        return $bookmark;
    }
}

