<?php

namespace App\Ui\Action;

use App\Application\Query\BoardListQuery;
use App\Infrastructure\Security\User\SymfonyUser;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * HomeAction constructor.
     *
     * @param CommandBus $commandBus
     * @param EngineInterface          $engine
     */
    public function __construct(CommandBus $commandBus, EngineInterface $engine)
    {
        $this->commandBus = $commandBus;
        $this->engine = $engine;
    }

    /**
     * @param UserInterface $user
     *
     * @return Response
     */
    public function __invoke(UserInterface $user)
    {
        if (!$user instanceof SymfonyUser) {
            throw new AccessDeniedException();
        }

        $boards = $this->commandBus->handle(new BoardListQuery($user->getModel()));

        return $this->engine->renderResponse('home.html.twig', [
            'boards' => $boards,
        ]);
    }
}
