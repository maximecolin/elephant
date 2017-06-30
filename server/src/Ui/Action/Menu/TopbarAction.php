<?php

namespace App\Ui\Action\Menu;

use App\Application\Query\BoardNavQuery;
use App\Infrastructure\Security\User\SymfonyUser;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TopbarAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * TopbarAction constructor.
     *
     * @param CommandBus            $commandBus
     * @param TokenStorageInterface $tokenStorage
     * @param EngineInterface       $engine
     */
    public function __construct(CommandBus $commandBus, TokenStorageInterface $tokenStorage, EngineInterface $engine)
    {
        $this->commandBus = $commandBus;
        $this->tokenStorage = $tokenStorage;
        $this->engine = $engine;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof SymfonyUser) {
            throw new AccessDeniedException();
        }

        $boards = $this->commandBus->handle(new BoardNavQuery($user->getModel()));

        return $this->engine->renderResponse('menu/topbar.html.twig', [
            'boards' => $boards
        ]);
    }
}
