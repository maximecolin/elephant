<?php

namespace App\Ui\Action\Collection;

use App\Application\Command\RemoveCollectionCommand;
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
     *
     * @return RedirectResponse
     */
    public function __invoke(int $collectionId)
    {
        $this->commandBus->handle(new RemoveCollectionCommand($collectionId));

        return new RedirectResponse($this->router->generate('home'));
    }
}
