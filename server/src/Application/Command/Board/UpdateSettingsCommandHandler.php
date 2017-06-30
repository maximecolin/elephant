<?php

namespace App\Application\Command\Board;

use App\Domain\Repository\CollaboratorRepositoryInterface;

class UpdateSettingsCommandHandler
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
     * @var UpdateSettingsCommand $command
     */
    public function handle(UpdateSettingsCommand $command)
    {

    }
}
