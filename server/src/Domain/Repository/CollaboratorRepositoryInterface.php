<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collaborator;

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
     * @param Collaborator $collaborator
     */
    public function remove(Collaborator $collaborator);
}
