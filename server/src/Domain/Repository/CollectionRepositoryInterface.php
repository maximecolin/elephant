<?php

namespace App\Domain\Repository;

use App\Domain\Dto\CollectionNavItem;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collection;

interface CollectionRepositoryInterface
{
    /**
     * @param int      $id
     * @param int|null $boardId
     *
     * @return Collection
     */
    public function findOneById(int $id, int $boardId = null) : Collection;

    /**
     * @param string $title
     *
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findOneByTitle(string $title) : Collection;

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
     * @param Collection $collection
     */
    public function add(Collection $collection);

    /**
     * @param Collection $collection
     */
    public function remove(Collection $collection);

    /**
     * @param int $boardId
     *
     * @return CollectionNavItem[]|array
     */
    public function getNavItems(int $boardId) : array;
}
