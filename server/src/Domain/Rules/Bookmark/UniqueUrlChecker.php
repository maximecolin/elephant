<?php

namespace App\Domain\Rules\Bookmark;

use App\Domain\Exception\DuplicateException;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;

class UniqueUrlChecker
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * UniqueUrlChecker constructor.
     *
     * @param BookmarkRepositoryInterface $bookmarkRepository
     */
    public function __construct(BookmarkRepositoryInterface $bookmarkRepository)
    {
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * @param Bookmark $bookmark
     *
     * @throws DuplicateException
     */
    public function check(Bookmark $bookmark)
    {
        try {
            if ($this->bookmarkRepository->findOnByUrl($bookmark->getUrl())->getId() !== $bookmark->getId()) {
                throw new DuplicateException('Url already exists.');
            }
        } catch (ModelNotFoundException $exception) {
            // If model is not found, the bookmark pass the check, then do nothing.
        }
    }
}
