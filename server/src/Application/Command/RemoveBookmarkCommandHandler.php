<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;

class RemoveBookmarkCommandHandler
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * RemoveBookmarkCommandHandler constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * @var RemoveBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(RemoveBookmarkCommand $command)
    {
        $bookmark = $this->bookmarkRepository->findOneById($command->id);
        $this->bookmarkRepository->remove($bookmark);

        return $bookmark;
    }
}

