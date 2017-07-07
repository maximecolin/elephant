<?php

namespace App\Infrastructure\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\QueryBuilder\UserQueryBuilder;
use Doctrine\ORM\NoResultException;

class UserRepository extends AbstractDoctrineRepository implements UserRepositoryInterface
{
    /**
     * @return UserQueryBuilder
     */
    private function createQueryBuilder()
    {
        return new UserQueryBuilder($this->entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(int $id): User
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterById($id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Bookmark not found.', $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByEmail(string $email): User
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

    /**
     * @param string $term
     *
     * @return User[]
     */
    public function findByTerm(string $term): array
    {
        return $this
            ->createQueryBuilder()
            ->filterByTerm($term)
            ->getQuery()
            ->getResult();
    }
}
