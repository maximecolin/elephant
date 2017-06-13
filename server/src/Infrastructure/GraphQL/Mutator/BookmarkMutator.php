<?php

namespace App\Infrastructure\GraphQL\Mutator;

use App\Application\Command\CreateBookmarkCommand;
use App\Domain\Model\Bookmark;
use App\Infrastructure\GraphQL\Normalizer\BookmarkNormalizer;
use League\Tactician\CommandBus;

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
     */
    public function createBookmark(string $url, string $title)
    {
        $command = new CreateBookmarkCommand($url, $title);

        /** @var Bookmark $bookmark */
        $bookmark = $this->bus->handle($command);

        return ['bookmark' => $this->normalizer->normalize($bookmark)];
    }
}
