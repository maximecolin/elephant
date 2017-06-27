<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\RemoveBookmarkCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RemoveAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RemoveAction constructor.
     *
     * @param CommandBus      $commandBus
     * @param RouterInterface $router
     */
    public function __construct(CommandBus $commandBus, RouterInterface $router)
    {
        $this->commandBus = $commandBus;
        $this->router = $router;
    }

    /**
     * @param int $collectionId
     * @param int $bookmarkId
     *
     * @return RedirectResponse
     */
    public function __invoke(int $collectionId, int $bookmarkId)
    {
        $this->commandBus->handle(new RemoveBookmarkCommand($bookmarkId));

        return new RedirectResponse($this->router->generate('collection', ['collectionId' => $collectionId]));
    }
}
