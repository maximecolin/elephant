<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Rules\Bookmark\UniqueUrlChecker;

class UpdateBookmarkCommandHandler
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
     * UpdateBookmarkCommandHandler constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param UniqueUrlChecker            $uniqueUrlChecker
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository, UniqueUrlChecker $uniqueUrlChecker)
    {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->uniqueUrlChecker = $uniqueUrlChecker;
    }

    /**
     * @var UpdateBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(UpdateBookmarkCommand $command)
    {
        $bookmark = $this->bookmarkRepository->findOneById($command->id);
        $bookmark->update($command->url, $command->title);

        $this->uniqueUrlChecker->check($bookmark);

        return $bookmark;
    }
}

