<?php

namespace App\Infrastructure\GraphQL\Resolver;

use App\Domain\Exception\DomainException;
use App\Domain\Repository\CollectionRepositoryInterface;
use App\Infrastructure\GraphQL\Normalizer\CollectionNormalizer;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\HttpFoundation\ParameterBag;

class CollectionResolver
{
    /**
     * @var CollectionRepositoryInterface
     */
    private $repository;

    /**
     * @var CollectionNormalizer
     */
    private $normalizer;

    /**
     * CollectionResolver constructor.
     *
     * @param CollectionRepositoryInterface $repository
     * @param CollectionNormalizer          $normalizer
     */
    public function __construct(CollectionRepositoryInterface $repository, CollectionNormalizer $normalizer)
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
    public function resolveCollection(Argument $argument)
    {
        try {
            $collection = $this->repository->findOneById($argument['id']);

            return $this->normalizer->normalize($collection);
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
    public function resolveCollections(Argument $argument, ResolveInfo $info)
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
}
