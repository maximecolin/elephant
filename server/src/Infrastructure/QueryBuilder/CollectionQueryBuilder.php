<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Dto\CollectionNavItem;
use App\Domain\Model\Bookmark;
use App\Domain\Model\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CollectionQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('collection')->from(Collection::class, 'collection');
    }

    /**
     * @return int
     */
    public function count()
    {
        $this
            ->select('COUNT(collection.id)')
            ->resetDQLPart('orderBy');

        return (int) $this->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return $this
     */
    public function paginate(int $offset, int $limit)
    {
        $this
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterById(int $id)
    {
        $this
            ->andWhere('collection.id = :id')
            ->setParameter('id', $id);

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function filterByTitle(string $title)
    {
        $this
            ->andWhere('collection.title = :title')
            ->setParameter('title', $title);

        return $this;
    }

    /**
     * @param int $boardId
     *
     * @return $this
     */
    public function filterByBoardId(int $boardId)
    {
        $this
            ->join('collection.board', 'board', 'WITH', 'board.id = :boardId')
            ->setParameter('boardId', $boardId);

        return $this;
    }

    /**
     * @return $this
     */
    public function getNavItems()
    {
        $this
            ->select(sprintf('NEW %s(collection.id, collection.title, COUNT(bookmark.id))', CollectionNavItem::class))
            ->leftJoin(Bookmark::class, 'bookmark', 'WITH', 'bookmark.collection = collection')
            ->groupBy('collection.id, collection.title')
        ;

        return $this;
    }
}
