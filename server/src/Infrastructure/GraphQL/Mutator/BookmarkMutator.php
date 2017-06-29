<?php

namespace App\Infrastructure\GraphQL\Mutator;

use App\Application\Command\Bookmark\CreateBookmarkCommand;
use App\Application\Command\Bookmark\RemoveBookmarkCommand;
use App\Application\Command\Bookmark\UpdateBookmarkCommand;
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
     * @param string $url
     * @param string $title
     * @param int    $collectionId
     *
     * @return array
     * @throws UserError
     */
    public function mutateCreateBookmark(string $url, string $title, int $collectionId)
    {
        try {
            /** @var Bookmark $bookmark */
            $bookmark = $this->bus->handle(new CreateBookmarkCommand($url, $title, $collectionId));

            return $this->normalizer->normalize($bookmark);
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param int    $id
     * @param string $url
     * @param string $title
     * @param int    $collectionId
     *
     * @return array
     * @throws UserError
     */
    public function mutateUpdateBookmark(int $id, string $url, string $title, int $collectionId)
    {
        try {
            /** @var Bookmark $bookmark */
            $bookmark = $this->bus->handle(new UpdateBookmarkCommand($id, $url, $title, $collectionId));

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
