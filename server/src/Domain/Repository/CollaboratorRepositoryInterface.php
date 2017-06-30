<?php

namespace App\Domain\Repository;

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
}
