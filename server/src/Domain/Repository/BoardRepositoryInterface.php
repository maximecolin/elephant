<?php

namespace App\Domain\Repository;

use App\Domain\Model\Board;
use App\Domain\Model\User;

interface BoardRepositoryInterface
{
    /**
     * @return Board[]
     */
    public function findAll() : array;

    /**
     * @param Board $board
     */
    public function add(Board $board);

    /**
     * @param int $id
     *
     * @return Board
     */
    public function findOneById(int $id) : Board;

    /**
     * @param User $user
     *
     * @return array
     */
    public function getNavItems(User $user) : array;
}
