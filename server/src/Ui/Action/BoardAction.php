<?php

namespace App\Ui\Action;

use App\Domain\Repository\BoardRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class BoardAction
{
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
     * @param BoardRepositoryInterface $boardRepository
     * @param EngineInterface          $engine
     */
    public function __construct(BoardRepositoryInterface $boardRepository, EngineInterface $engine)
    {
        $this->boardRepository = $boardRepository;
        $this->engine = $engine;
    }

    /**
     * @param int $boardId
     *
     * @return Response
     */
    public function __invoke(int $boardId)
    {
        $board = $this->boardRepository->findOneById($boardId);

        return $this->engine->renderResponse('board.html.twig', [
            'board' => $board
        ]);
    }
}
