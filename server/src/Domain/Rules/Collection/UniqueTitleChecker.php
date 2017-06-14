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
        try {
            if ($this->collectionRepository->findOnByTitle($collection->getTitle())->getId() !== $collection->getId()) {
                throw new DuplicateException('Title already exists.');
            }
        } catch (ModelNotFoundException $exception) {
            // If model is not found, the collection pass the check, then do nothing.
        }
    }
}
