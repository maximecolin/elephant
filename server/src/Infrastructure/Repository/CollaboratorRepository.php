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
    public function findOneByEmail(string $email): Collaborator
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterByEmail($email)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Bookmark not found.', $exception);
        }
    }
}
