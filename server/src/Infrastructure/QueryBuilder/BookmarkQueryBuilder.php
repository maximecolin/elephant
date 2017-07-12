<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\Bookmark;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class BookmarkQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('bookmark')->from(Bookmark::class, 'bookmark');
    }

    /**
     * @return int
     */
    public function count()
    {
        $this
            ->select('COUNT(bookmark.id)')
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
            ->andWhere('bookmark.id = :id')
            ->setParameter('id', $id);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function filterByUrl(string $url)
    {
        $this
            ->andWhere('bookmark.url = :url')
            ->setParameter('url', $url);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterByCollectionId(int $id)
    {
        $this
            ->join('bookmark.collection', 'collection', 'WITH', 'collection.id = :collection_id')
            ->setParameter('collection_id', $id);

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function filterByBoardId(int $id)
    {
        $this
            ->join('collection.board', 'board', 'WITH', 'board.id = :board_id')
            ->setParameter('board_id', $id);

        return $this;
    }
}
