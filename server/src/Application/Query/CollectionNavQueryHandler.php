<?php

namespace App\Application\Query;

use App\Domain\Dto\CollectionNavItem;
use App\Domain\Repository\CollectionRepositoryInterface;

class CollectionNavQueryHandler
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * CollectionNavQueryHandler constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     */
    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    /**
     * @param CollectionNavQuery $query
     *
     * @return CollectionNavItem[]|array
     */
    public function handle(CollectionNavQuery $query)
    {
        $items = $this->collectionRepository->getNavItems();

        foreach ($items as $item) {
            if ($item->getId() === $query->collectionId) {
                $item->markAsActive();
                break;
            }
        }

        return $items;
    }
}
