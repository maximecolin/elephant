<?php

namespace App\Infrastructure\GraphQL\Mutator;

use App\Application\Command\CreateCollectionCommand;
use App\Application\Command\UpdateCollectionCommand;
use App\Domain\Exception\DomainException;
use App\Domain\Model\Collection;
use App\Infrastructure\GraphQL\Normalizer\CollectionNormalizer;
use League\Tactician\CommandBus;
use Overblog\GraphQLBundle\Error\UserError;

class CollectionMutator
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var CollectionNormalizer
     */
    private $normalizer;

    /**
     * CollectionMutator constructor.
     *
     * @param CommandBus         $bus
     * @param CollectionNormalizer $normalizer
     */
    public function __construct(CommandBus $bus, CollectionNormalizer $normalizer)
    {
        $this->bus = $bus;
        $this->normalizer = $normalizer;
    }

    /**
     * @param string $title
     *
     * @return array
     * @throws UserError
     */
    public function mutateCreateCollection(string $title)
    {
        try {
            /** @var Collection $collection */
            $collection = $this->bus->handle(new CreateCollectionCommand($title));

            return $this->normalizer->normalize($collection);
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param int    $id
     * @param string $title
     *
     * @return array
     * @throws UserError
     */
    public function mutateUpdateCollection(int $id, string $title)
    {
        try {
            /** @var Collection $collection */
            $collection = $this->bus->handle(new UpdateCollectionCommand($id, $title));

            return $this->normalizer->normalize($collection);
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }
}
