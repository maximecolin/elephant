<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Board;
use App\Domain\Repository\BoardRepositoryInterface;

class CreateBoardCommandHandler
{
    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * CreateBoardCommandHandler constructor.
     *
     * @param BoardRepositoryInterface $boardRepository
     */
    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * @var CreateBoardCommand $command
     *
     * @return Board
     */
    public function handle(CreateBoardCommand $command)
    {
        $board = new Board($command->title);

        $this->boardRepository->add($board);

        return $board;
    }
}

