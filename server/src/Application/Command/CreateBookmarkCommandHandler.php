<?php

namespace App\Application\Command;

use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;

class CreateBookmarkCommandHandler
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * CreateBookmarkCommandHandler constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * @var CreateBookmarkCommand $command
     *
     * @return Bookmark
     */
    public function handle(CreateBookmarkCommand $command)
    {
        $bookmark = new Bookmark($command->url, $command->title);

        $this->bookmarkRepository->add($bookmark);

        return $bookmark;
    }
}

