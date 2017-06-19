<?php

namespace App\Infrastructure\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collection;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Infrastructure\QueryBuilder\CollectionQueryBuilder;
use Doctrine\ORM\NoResultException;

class CollectionRepository extends AbstractDoctrineRepository implements CollectionRepositoryInterface
{
    /**
     * @return CollectionQueryBuilder
     */
    private function createQueryBuilder()
    {
        return new CollectionQueryBuilder($this->entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(int $id) : Collection
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterById($id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Collection not found.', $exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByTitle(string $title) : Collection
    {
        try {
            return $this
                ->createQueryBuilder()
                ->filterByTitle($title)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $exception) {
            throw new ModelNotFoundException('Collection not found.', $exception);
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
     * @param Collection $collection
     */
    public function add(Collection $collection)
    {
        $this->entityManager->persist($collection);
    }
}
