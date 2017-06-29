<?php

namespace App\Ui\Action\Bookmark;

use App\Application\Command\RemoveBookmarkCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
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
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * RemoveAction constructor.
     *
     * @param CommandBus        $commandBus
     * @param RouterInterface   $router
     * @param FlashBagInterface $flashBag
     */
    public function __construct(CommandBus $commandBus, RouterInterface $router, FlashBagInterface $flashBag)
    {
        $this->commandBus = $commandBus;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    /**
     * @param int $boardId
     * @param int $collectionId
     * @param int $bookmarkId
     *
     * @return RedirectResponse
     */
    public function __invoke(int $boardId, int $collectionId, int $bookmarkId)
    {
        $this->commandBus->handle(new RemoveBookmarkCommand($bookmarkId));
        $this->flashBag->add('inverse', 'Le favoris a été supprimé.');

        return new RedirectResponse($this->router->generate('collection', [
            'boardId' => $boardId,
            'collectionId' => $collectionId,
        ]));
    }
}
