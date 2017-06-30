<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Dto\BoardListItem;
use App\Domain\Dto\BoardNavItem;
use App\Domain\Model\Board;
use App\Domain\Model\Bookmark;
use App\Domain\Model\Collaborator;
use App\Domain\Model\Collection;
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

        $this->select('board')->from(Board::class, 'board', 'board.id');
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

    /**
     * @param User $user
     *
     * @return $this
     */
    public function selectListItem(User $user)
    {
        $this
            ->filterByUser($user)
            ->select(sprintf('NEW %s(
                board.id, 
                board.title, 
                collaborator.level,
                (SELECT COUNT(cb.user) FROM %s cb WHERE cb.board = board),
                (SELECT COUNT(co.id) FROM %s co WHERE co.board = board),
                (SELECT COUNT(bm.id) FROM %s bm INNER JOIN %s bmc WITH bm.collection = bmc WHERE bmc.board = board)
            )', BoardListItem::class, Collaborator::class, Collection::class, Bookmark::class, Collection::class));

        return $this;
    }
}
