<?php

namespace App\Ui\Action;

use App\Domain\Repository\BoardRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeAction
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
     * HomeAction constructor.
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
     * @return Response
     */
    public function __invoke()
    {
        $boards = $this->boardRepository->findAll();

        return $this->engine->renderResponse('home.html.twig', [
            'boards' => $boards,
        ]);
    }
}
