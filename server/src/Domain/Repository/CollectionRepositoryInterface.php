<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collection;

interface CollectionRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findOneById(int $id) : Collection;

    /**
     * @param string $title
     *
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findOnByTitle(string $title) : Collection;

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
}
