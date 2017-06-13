<?php

namespace App\Infrastructure\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Bookmark;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Infrastructure\QueryBuilder\BookmarkQueryBuilder;
use Doctrine\ORM\NoResultException;

class BookmarkRepository extends AbstractDoctrineRepository implements BookmarkRepositoryInterface
{
    /**
     * @return BookmarkQueryBuilder
     */
    private function createQueryBuilder()
    {
        return new BookmarkQueryBuilder($this->entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(int $id): Bookmark
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
    public function findAll(): array
    {
        return $this
            ->createQueryBuilder()
            ->getQuery()
            ->getResult();
    }
}
