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
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function findAll(int $offset, int $limit) : array;

    /**
     * @return int
     */
    public function countAll() : int;

    /**
     * @param Bookmark $bookmark
     */
    public function add(Bookmark $bookmark);

    /**
     * @param int $id
     *
     * @return int
     */
    public function countAllByCollectionId(int $id) : int;

    /**
     * @param int $id
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function findAllByCollectionId(int $id, int $offset, int $limit) : array;

    /**
     * @param Bookmark $bookmark
     */
    public function remove(Bookmark $bookmark);
}
