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
    public function findOneById(int $id, int $collectionId = null, int $boardId = null) : Bookmark
    {
        try {
            $queryBuilder = $this->createQueryBuilder();

            if (null !== $collectionId) {
                $queryBuilder->filterByCollectionId($collectionId)->addSelect('collection');
            }

            if (null !== $boardId) {
                $queryBuilder->filterByBoardId($boardId)->addSelect('board');
            }

            return $queryBuilder
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
    public function findOneByUrl(string $url) : Bookmark
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterByUrl($url)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Bookmark not found.', $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(int $offset, int $limit) : array
    {
        return $this
            ->createQueryBuilder()
            ->paginate($offset, $limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countAll() : int
    {
        return $this
            ->createQueryBuilder()
            ->count();
    }

    /**
     * @param Bookmark $bookmark
     */
    public function add(Bookmark $bookmark)
    {
        $this->entityManager->persist($bookmark);
    }

    /**
     * {@inheritdoc}
     */
    public function countAllByCollectionId(int $id) : int
    {
        return $this
            ->createQueryBuilder()
            ->filterByCollectionId($id)
            ->count();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByCollectionId(int $id, int $offset, int $limit) : array
    {
        return $this
            ->createQueryBuilder()
            ->filterByCollectionId($id)
            ->paginate($offset, $limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Bookmark $bookmark)
    {
        $this->entityManager->remove($bookmark);
    }
}
