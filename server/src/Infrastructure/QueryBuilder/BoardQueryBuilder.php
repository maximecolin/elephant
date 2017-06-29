<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\Board;
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
}
