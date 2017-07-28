<?php

namespace App\Ui\Action\Menu;

use App\Application\Query\BoardNavQuery;
use App\Domain\Model\User;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class TopbarAction
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
     * TopbarAction constructor.
     *
     * @param CommandBus            $commandBus
     * @param EngineInterface       $engine
     */
    public function __construct(CommandBus $commandBus, EngineInterface $engine)
    {
        $this->commandBus = $commandBus;
        $this->engine = $engine;
    }

    /**
     * @param User $user
     *
     * @return Response
     */
    public function __invoke(User $user)
    {
        $boards = $this->commandBus->handle(new BoardNavQuery($user));

        return $this->engine->renderResponse('menu/topbar.html.twig', [
            'boards' => $boards
        ]);
    }
}
