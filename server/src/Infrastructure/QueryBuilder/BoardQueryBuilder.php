<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Dto\BoardNavItem;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class BoardQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('board')->from(Board::class, 'board');
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterById(int $id)
    {
        $this
            ->andWhere('board.id = :id')
            ->setParameter('id', $id);

        return $this;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function filterByUser(User $user)
    {
        $this
            ->join(Collaborator::class, 'collaborator', 'WITH', 'collaborator.board = board AND collaborator.user = :user')
            ->setParameter('user', $user);

        return $this;
    }

    /**
     * @return $this
     */
    public function selectNavItems()
    {
        $this->select(sprintf('NEW %s(board.id, board.title)', BoardNavItem::class));

        return $this;
    }
}
