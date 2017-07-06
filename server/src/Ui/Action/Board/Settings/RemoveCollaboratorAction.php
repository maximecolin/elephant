<?php

namespace App\Ui\Action\Board\Settings;

use App\Application\Command\Board\RemoveCollaboratorCommand;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class RemoveCollaboratorAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RemoveCollaborator constructor.
     *
     * @param CommandBus        $commandBus
     * @param FlashBagInterface $flashBag
     * @param RouterInterface   $router
     */
    public function __construct(
        CommandBus $commandBus,
        FlashBagInterface $flashBag,
        RouterInterface $router
    ) {
        $this->commandBus = $commandBus;
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * @param int $boardId
     * @param int $userId
     *
     * @return RedirectResponse
     */
    public function __invoke(int $boardId, int $userId)
    {
        $this->commandBus->handle(new RemoveCollaboratorCommand($boardId, $userId));
        $this->flashBag->add('inverse', 'Le collaborateur a été supprimé.');

        return new RedirectResponse($this->router->generate('board_settings_collaborator', [
            'boardId' => $boardId,
        ]));
    }
}
