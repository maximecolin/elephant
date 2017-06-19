<?php

namespace App\Infrastructure\GraphQL\Mutator;

use App\Application\Command\CreateBookmarkCommand;
use App\Application\Command\RemoveBookmarkCommand;
use App\Application\Command\UpdateBookmarkCommand;
use App\Domain\Exception\DomainException;
use App\Domain\Model\Bookmark;
use App\Infrastructure\GraphQL\Normalizer\BookmarkNormalizer;
use League\Tactician\CommandBus;
use Overblog\GraphQLBundle\Error\UserError;

class BookmarkMutator
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var BookmarkNormalizer
     */
    private $normalizer;

    /**
     * BookmarkMutator constructor.
     *
     * @param CommandBus         $bus
     * @param BookmarkNormalizer $normalizer
     */
    public function __construct(CommandBus $bus, BookmarkNormalizer $normalizer)
    {
        $this->bus = $bus;
        $this->normalizer = $normalizer;
    }

    /**
     * @param string   $url
     * @param string   $title
     * @param int      $collectionId
     * @param int|null $id
     *
     * @return array
     * @throws UserError
     */
    public function mutateBookmark(string $url, string $title, int $collectionId, int $id = null) : array
    {
        try {
            $command = $id === null
                ? new CreateBookmarkCommand($url, $title, $collectionId)
                : new UpdateBookmarkCommand($id, $url, $title, $collectionId);

            /** @var Bookmark $bookmark */
            $bookmark = $this->bus->handle($command);

            return $this->normalizer->normalize($bookmark);
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param int $id
     *
     * @return Bookmark
     * @throws UserError
     */
    public function mutateRemoveBookmark(int $id)
    {
        try {
            return $this->bus->handle(new RemoveBookmarkCommand($id));
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }
}
