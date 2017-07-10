<?php

namespace App\Ui\Action;

use App\Domain\Repository\BoardRepositoryInterface;
use App\Infrastructure\Helper\SecurityTrait;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BoardAction
{
    use SecurityTrait;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * BoardAction constructor.
     *
     * @param BoardRepositoryInterface      $boardRepository
     * @param EngineInterface               $engine
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        EngineInterface $engine,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->boardRepository = $boardRepository;
        $this->engine = $engine;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param int $boardId
     *
     * @return Response
     */
    public function __invoke(int $boardId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_READ', $board);

        return $this->engine->renderResponse('board.html.twig', [
            'board' => $board
        ]);
    }
}
