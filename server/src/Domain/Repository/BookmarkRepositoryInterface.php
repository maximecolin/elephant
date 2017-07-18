<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Bookmark;
use App\Domain\Model\Collection;

interface BookmarkRepositoryInterface
{
    /**
     * @param int      $id
     * @param int|null $collectionId
     * @param int|null $boardId
     *
     * @return Bookmark
     */
    public function findOneById(int $id, int $collectionId = null, int $boardId = null) : Bookmark;

    /**
     * @param string $url
     *
     * @return Bookmark
     * @throws ModelNotFoundException
     */
    public function findOneByUrl(string $url) : Bookmark;

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
    public function paginateByCollectionId(int $id, int $offset, int $limit) : array;

    /**
     * @param Bookmark $bookmark
     */
    public function remove(Bookmark $bookmark);

    /**
     * @param Collection $collection
     *
     * @return Bookmark[]
     */
    public function findByCollection(Collection $collection) : array;
}
