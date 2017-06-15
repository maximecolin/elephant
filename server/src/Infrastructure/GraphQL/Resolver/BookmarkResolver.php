<?php

namespace App\Infrastructure\GraphQL\Resolver;

use App\Domain\Exception\DomainException;
use App\Domain\Repository\BookmarkRepositoryInterface;
use App\Infrastructure\GraphQL\Normalizer\BookmarkNormalizer;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\HttpFoundation\ParameterBag;

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
        } catch (DomainException $exception) {
           throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param Argument    $argument
     * @param ResolveInfo $info
     *
     * @return array
     */
    public function resolveBookmarks(Argument $argument, ResolveInfo $info)
    {
        $selection = new ParameterBag($info->getFieldSelection());

        $total = $selection->has('total')
            ? $this->repository->countAll()
            : 0;

        $edges = $selection->has('edges')
            ? $this->repository->findAll($argument['offset'], $argument['limit'])
            : [];

        return [
            'total' => $total,
            'offset' => $argument['offset'],
            'limit' => $argument['limit'],
            'edges' => array_map([$this->normalizer, 'normalize'], $edges),
        ];
    }

    /**
     * @param array       $collection
     * @param Argument    $argument
     * @param ResolveInfo $info
     *
     * @return array
     */
    public function resolveCollectionBookmarks(array $collection, Argument $argument, ResolveInfo $info)
    {
        $selection = new ParameterBag($info->getFieldSelection());

        $total = $selection->has('total')
            ? $this->repository->countAllByCollectionId($collection['id'])
            : 0;

        $edges = $selection->has('edges')
            ? $this->repository->findAllByCollectionId($collection['id'], $argument['offset'], $argument['limit'])
            : [];

        return [
            'total' => $total,
            'offset' => $argument['offset'],
            'limit' => $argument['limit'],
            'edges' => array_map([$this->normalizer, 'normalize'], $edges),
        ];
    }
}
