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
        if (!$this->isUnique($bookmark->getUrl(), $bookmark->getId())) {
            throw new DuplicateException('Url already exists.');
        }
    }

    /**
     * @param string $url
     * @param int    $id
     *
     * @return bool
     */
    public function isUnique(string $url, int $id = null)
    {
        try {
            return $this->bookmarkRepository->findOneByUrl($url)->getId() === $id;
        } catch (ModelNotFoundException $exception) {
            return true;
        }
    }
}
