<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class CreateBoardCommandHandler
{
    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * CreateBoardCommandHandler constructor.
     *
     * @param BoardRepositoryInterface        $boardRepository
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        CollaboratorRepositoryInterface $collaboratorRepository
    ) {
        $this->boardRepository = $boardRepository;
        $this->collaboratorRepository = $collaboratorRepository;
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

        $collaborator = new Collaborator($command->user, $board, Collaborator::LEVEL_OWNER);
        $this->collaboratorRepository->add($collaborator);

        return $board;
    }
}

