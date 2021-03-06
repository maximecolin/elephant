<?php

namespace App\Ui\Action;

use App\Application\Query\CollectionNavQuery;
use App\Domain\Model\Board;
use App\Domain\Model\User;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class CollectionNavAction
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollectionNavAction constructor.
     *
     * @param CommandBus      $commandBus
     * @param RequestStack    $requestStack
     * @param EngineInterface $engine
     */
    public function __construct(
        CommandBus $commandBus,
        RequestStack $requestStack,
        EngineInterface $engine)
    {
        $this->commandBus = $commandBus;
        $this->engine = $engine;
        $this->requestStack = $requestStack;
    }

    /**
     * @param Board $board
     *
     * @return Response
     */
    public function __invoke(Board $board)
    {
        $boardId = $this->requestStack->getMasterRequest()->attributes->getInt('boardId');
        $collectionId = $this->requestStack->getMasterRequest()->attributes->getInt('collectionId');
        $collections = $this->commandBus->handle(new CollectionNavQuery($boardId, $collectionId));

        return $this->engine->renderResponse('collection-nav.html.twig', [
            'board' => $board,
            'boardId' => $boardId,
            'collections' => $collections,
        ]);
    }
}
