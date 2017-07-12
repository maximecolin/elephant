<?php

namespace App\Ui\Action;

use App\Application\Query\CollectionViewQuery;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Infrastructure\Helper\SecurityTrait;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CollectionAction
{
    use SecurityTrait;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollectionAction constructor.
     *
     * @param CommandBus                    $commandBus
     * @param BoardRepositoryInterface      $boardRepository
     * @param EngineInterface               $engine
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        CommandBus $commandBus,
        BoardRepositoryInterface $boardRepository,
        EngineInterface $engine,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->commandBus = $commandBus;
        $this->boardRepository = $boardRepository;
        $this->engine = $engine;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param int $boardId
     * @param int $collectionId
     *
     * @return string
     */
    public function __invoke(int $boardId, int $collectionId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_READ', $board);

        $collection = $this->commandBus->handle(new CollectionViewQuery($collectionId));

        return $this->engine->renderResponse('collection.html.twig', [
            'board'      => $board,
            'boardId'    => $boardId,
            'collection' => $collection,
        ]);
    }
}
