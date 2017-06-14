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
     * @param string   $title
     * @param int|null $id
     *
     * @return array
     * @throws UserError
     */
    public function mutateCollection(string $title, int $id = null) : array
    {
        try {
            $command = $id === null
                ? new CreateCollectionCommand($title)
                : new UpdateCollectionCommand($id, $title);

            /** @var Collection $collection */
            $collection = $this->bus->handle($command);

            return $this->normalizer->normalize($collection);
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }
}
