<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collaborator;

interface CollaboratorRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return Collaborator
     * @throws ModelNotFoundException
     */
    public function findOneByEmail(string $email) : Collaborator;
}
