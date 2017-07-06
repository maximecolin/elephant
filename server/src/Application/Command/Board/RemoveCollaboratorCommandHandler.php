<?php

namespace App\Application\Command\Board;

use App\Domain\Repository\CollaboratorRepositoryInterface;

class RemoveCollaboratorCommandHandler
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * RemoveCollaboratorCommandHandler constructor.
     *
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * @var RemoveCollaboratorCommand $command
     */
    public function handle(RemoveCollaboratorCommand $command)
    {
        $collaborator = $this->collaboratorRepository->findOneByBoardIdAndUserId($command->boardId, $command->userId);

        $this->collaboratorRepository->remove($collaborator);
    }
}

