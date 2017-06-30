<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Collaborator;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Infrastructure\QueryBuilder\CollaboratorQueryBuilder;

class CollaboratorRepository extends AbstractDoctrineRepository implements CollaboratorRepositoryInterface
{
    /**
     * @return CollaboratorQueryBuilder
     */
    private function createQueryBuilder()
    {
        return new CollaboratorQueryBuilder($this->entityManager);
    }
    
    /**
     * {@inheritdoc}
     */
    public function add(Collaborator $collaborator)
    {
        $this->entityManager->persist($collaborator);
    }

    /**
     * @param int $boardId
     *
     * @return Collaborator[]
     */
    public function findByBoardId(int $boardId)
    {
        return $this
            ->createQueryBuilder()
            ->filterByBoardId($boardId)
            ->getQuery()
            ->getResult();
    }
}
