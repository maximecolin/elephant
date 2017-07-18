<?php

namespace App\Application\Query;

use App\Domain\Assembler\CollectionViewAssembler;
use App\Domain\Dto\CollectionView;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;

class CollectionViewQueryHandler
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var BookmarkRepositoryInterface
     */
    private $bookmarkRepository;

    /**
     * CollectionViewQueryHandler constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param BookmarkRepositoryInterface   $bookmarkRepository
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        BookmarkRepositoryInterface $bookmarkRepository
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->bookmarkRepository = $bookmarkRepository;
    }

    /**
     * @param CollectionViewQuery $query
     *
     * @return CollectionView
     */
    public function handle(CollectionViewQuery $query)
    {
        $collection = $this->collectionRepository->findOneById($query->id);
        $bookmarks = $this->bookmarkRepository->paginateByCollectionId($query->id, $query->offset, $query->limit);

        $assembler = new CollectionViewAssembler();

        return $assembler->assemble($collection, $bookmarks);
    }
}
