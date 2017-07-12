<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\Collaborator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CollaboratorQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('collaborator')->from(Collaborator::class, 'collaborator');
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterByBoardId(int $id)
    {
        $this
            ->andWhere('collaborator.board = :board_id')
            ->setParameter('board_id', $id);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterByUserId(int $id)
    {
        $this
            ->andWhere('collaborator.user = :user_id')
            ->setParameter('user_id', $id);

        return $this;
    }

    /**
     * @param string $level
     *
     * @return $this
     */
    public function filterByLevel(string $level)
    {
        $this
            ->andWhere('collaborator.level = :level')
            ->setParameter('level', $level);

        return $this;
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return (int) $this
            ->select('COUNT(collaborator.level)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
