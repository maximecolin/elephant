<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;

interface CollaboratorRepositoryInterface
{
    /**
     * @param Collaborator $collaborator
     */
    public function add(Collaborator $collaborator);

    /**
     * @param int $boardId
     *
     * @return Collaborator[]
     */
    public function findByBoardId(int $boardId);

    /**
     * @param int $boardId
     * @param int $userId
     *
     * @return Collaborator
     * @throws ModelNotFoundException
     */
    public function findOneByBoardIdAndUserId(int $boardId, int $userId) : Collaborator;

    /**
     * @param Board  $board
     * @param User   $user
     *
     * @return Collaborator
     * @throws ModelNotFoundException
     */
    public function findOneByBoardUserAndLevel(Board $board, User $user) : Collaborator;

    /**
     * @param Collaborator $collaborator
     */
    public function remove(Collaborator $collaborator);

    /**
     * @param Board  $board
     * @param string $level
     *
     * @return int
     */
    public function countByLevel(Board $board, string $level) : int;
}
