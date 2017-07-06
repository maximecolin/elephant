<?php

namespace App\Infrastructure\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collaborator;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Infrastructure\QueryBuilder\CollaboratorQueryBuilder;
use Doctrine\ORM\NoResultException;

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
     * {@inheritdoc}
     */
    public function findByBoardId(int $boardId)
    {
        return $this
            ->createQueryBuilder()
            ->filterByBoardId($boardId)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByBoardIdAndUserId(int $boardId, int $userId) : Collaborator
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterByBoardId($boardId)
                ->filterByUserId($userId)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Collaborator not found', $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Collaborator $collaborator)
    {
        $this->entityManager->remove($collaborator);
    }
}
