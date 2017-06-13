<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Bookmark;

interface BookmarkRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Bookmark
     * @throws ModelNotFoundException
     */
    public function findOneById(int $id) : Bookmark;

    /**
     * @param string $url
     *
     * @return Bookmark
     * @throws ModelNotFoundException
     */
    public function findOnByUrl(string $url) : Bookmark;

    /**
     * @return array
     */
    public function findAll() : array;

    /**
     * @param Bookmark $bookmark
     */
    public function add(Bookmark $bookmark);
}
