<?php

namespace App\Application\Command\Bookmark;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Domain\Rules\Bookmark\UniqueUrlChecker;

class UpdateBookmarkCommandHandler
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var UniqueUrlChecker
     */
    private $uniqueUrlChecker;

    /**
     * UpdateBookmarkCommandHandler constructor.
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
        $this->collectionRepository = $collectionRepository;
        $this->uniqueUrlChecker = $uniqueUrlChecker;
    }

    /**
     * @param UpdateBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(UpdateBookmarkCommand $command)
    {
        $bookmark = $this->bookmarkRepository->findOneById($command->id);
        $bookmark->update($command->url, $command->title);

        if ($bookmark->getId() !== $command->collectionId) {
            $collection = $this->collectionRepository->findOneById($command->collectionId);
            $bookmark->moveTo($collection);
        }

        $this->uniqueUrlChecker->check($bookmark);

        return $bookmark;
    }
}

