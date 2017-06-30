<?php

namespace App\Infrastructure\Repository;

use App\Domain\Dto\BoardListItem;
use App\Domain\Model\Board;
use App\Domain\Model\User;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Infrastructure\QueryBuilder\BoardQueryBuilder;

class BoardRepository extends AbstractDoctrineRepository implements BoardRepositoryInterface
{
    /**
     * @return BoardQueryBuilder
     */
    private function createQueryBuilder()
    {
        return new BoardQueryBuilder($this->entityManager);
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

    /**
     * {@inheritdoc}
     */
    public function add(Board $board)
    {
        $this->entityManager->persist($board);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(int $id): Board
    {
        return $this
            ->createQueryBuilder()
            ->filterById($id)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getNavItems(User $user) : array
    {
        return $this
            ->createQueryBuilder()
            ->selectNavItems()
            ->filterByUser($user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function findByUser(User $user): array
    {
        return $this
            ->createQueryBuilder()
            ->filterByUser($user)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getListItems(User $user) : array
    {
        return $this
            ->createQueryBuilder()
            ->selectListItem($user)
            ->getQuery()
            ->getResult();
    }
}
