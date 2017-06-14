<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Rules\Bookmark\UniqueTitleChecker;

class CreateBookmarkCommandHandler
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;


    /**
     * @var UniqueTitleChecker
     */
    private $uniqueUrlChecker;

    /**
     * CreateBookmarkCommandHandler constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     * @param UniqueTitleChecker          $uniqueUrlChecker
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository, UniqueTitleChecker $uniqueUrlChecker)
    {
        $this->bookmarkRepository = $bookmarkRepository;
        $this->uniqueUrlChecker = $uniqueUrlChecker;
    }

    /**
     * @var CreateBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(CreateBookmarkCommand $command)
    {
        $bookmark = new Bookmark($command->url, $command->title);

        $this->uniqueUrlChecker->check($bookmark);
        $this->bookmarkRepository->add($bookmark);

        return $bookmark;
    }
}

