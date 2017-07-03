<?php

namespace App\Application\Command\Board;

use App\Domain\Repository\CollaboratorRepositoryInterface;

class UpdateCollaboratorsCommandHandler
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * UpdateSettingsCommandHandler constructor.
     *
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * @var UpdateCollaboratorsCommand $command
     */
    public function handle(UpdateCollaboratorsCommand $command)
    {

    }
}
