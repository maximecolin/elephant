<?php

namespace App\Infrastructure\GraphQL\Mutator;

use App\Application\Command\CreateBookmarkCommand;
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
     * @param string $url
     * @param string $title
     *
     * @return array
     * @throws UserError
     */
    public function createBookmark(string $url, string $title)
    {
        try {
            $command = new CreateBookmarkCommand($url, $title);

            /** @var Bookmark $bookmark */
            $bookmark = $this->bus->handle($command);

            return ['bookmark' => $this->normalizer->normalize($bookmark)];
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }

    /**
     * @param int    $id
     * @param string $url
     * @param string $title
     *
     * @return array
     * @throws UserError
     */
    public function updateBookmark(int $id, string $url, string $title)
    {
        try {
            $command = new UpdateBookmarkCommand($id, $url, $title);

            /** @var Bookmark $bookmark */
            $bookmark = $this->bus->handle($command);

            return ['bookmark' => $this->normalizer->normalize($bookmark)];
        } catch (DomainException $exception) {
            throw new UserError($exception->getMessage());
        }
    }
}
