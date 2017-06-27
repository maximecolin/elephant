<?php

namespace App\Domain\Rules\Collection;

use App\Domain\Exception\DuplicateException;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Collection;
use App\Domain\Repository\CollectionRepositoryInterface;

class UniqueTitleChecker
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * UniqueTitleChecker constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     */
    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @param Collection $collection
     *
     * @throws DuplicateException
     */
    public function check(Collection $collection)
    {
        if (!$this->isUnique($collection->getTitle(), $collection->getId())) {
            throw new DuplicateException('Title already exists.');
        }
    }

    /**
     * @param string $title
     * @param int    $id
     *
     * @return bool
     */
    public function isUnique(string $title, int $id = null)
    {
        try {
            return $this->collectionRepository->findOneByTitle($title)->getId() === $id;
        } catch (ModelNotFoundException $exception) {
            return true;
        }
    }
}
