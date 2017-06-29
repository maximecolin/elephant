<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Collaborator;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class CollaboratorRepository extends AbstractDoctrineRepository implements CollaboratorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(Collaborator $collaborator)
    {
        $this->entityManager->persist($collaborator);
    }
}
