<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\Collection\RemoveCollectionCommand;
use App\Infrastructure\Helper\RoutingTrait;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class RemoveAction
{
    use RoutingTrait;

    /**
     * @var CommandBus
     */
    private $commandBus;

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
     *
     * @return RedirectResponse
     */
    public function __invoke(int $boardId, int $collectionId)
    {
        $this->commandBus->handle(new RemoveCollectionCommand($collectionId));
        $this->flashBag->add('inverse', 'La collection a été supprimé.');

        return $this->redirectToRoute('board', [
            'boardId' => $boardId,
        ]);
    }
}
