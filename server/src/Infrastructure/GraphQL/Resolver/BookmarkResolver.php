<?php

namespace App\Infrastructure\GraphQL\Resolver;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Infrastructure\GraphQL\Normalizer\BookmarkNormalizer;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Error\UserError;

class BookmarkResolver
{
    /**
     * @var BookmarkRepositoryInterface
     */
    private $repository;

    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * BookmarkResolver constructor.
     *
     * @param BookmarkRepositoryInterface $repository
     * @param BookmarkNormalizer          $normalizer
     */
    public function __construct(BookmarkRepositoryInterface $repository, BookmarkNormalizer $normalizer)
    {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
    }

    /**
     * @param Argument $argument
     *
     * @return array
     * @throws UserError
     */
    public function resolveBookmark(Argument $argument)
    {
        try {
            $bookmark = $this->repository->findOneById($argument['id']);

            return $this->normalizer->normalize($bookmark);
        } catch (ModelNotFoundException $exception) {
           throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param Argument $argument
     *
     * @return array
     */
    public function resolveBookmarks(Argument $argument)
    {
        $bookmarks = $this->repository->findAll();

        return array_map([$this->normalizer, 'normalize'], $bookmarks);
    }
}
