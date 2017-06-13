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
}
