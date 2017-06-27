<?php

namespace App\Ui\Action;

use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Domain\Repository\CollectionRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class CollectionAction
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
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollectionAction constructor.
     *
     * @param CollectionRepositoryInterface $collectionRepository
     * @param BookmarkRepositoryInterface   $bookmarkRepository
     * @param EngineInterface               $engine
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        BookmarkRepositoryInterface $bookmarkRepository,
        EngineInterface $engine
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->bookmarkRepository = $bookmarkRepository;
        $this->engine = $engine;
    }

    /**
     * @param int $collectionId
     *
     * @return string
     */
    public function __invoke(int $collectionId)
    {
        $collection = $this->collectionRepository->findOneById($collectionId);
        $bookmarks = $this->bookmarkRepository->findAllByCollectionId($collectionId, 0, 100);

        return $this->engine->renderResponse('collection.html.twig', [
            'collection' => $collection,
            'bookmarks' => $bookmarks,
        ]);
    }
}
