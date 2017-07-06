<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Collaborator;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class AddCollaboratorCommandHandler
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * AddCollaboratorCommandHandler constructor.
     *
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * @var AddCollaboratorCommand $command
     *
     * @return Collaborator
     */
    public function handle(AddCollaboratorCommand $command)
    {
        $collaborator = new Collaborator($command->user, $command->board, Collaborator::LEVEL_READ);

        $this->collaboratorRepository->add($collaborator);

        return $collaborator;
    }
}

