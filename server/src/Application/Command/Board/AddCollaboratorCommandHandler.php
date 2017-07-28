<?php

namespace App\Application\Command\Board;

use App\Application\Event\EventRecorderInterface;
use App\Domain\Event\CollaboratorAddedEvent;
use App\Domain\Model\Collaborator;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Domain\Rules\Collaborator\UniqueChecker;

class AddCollaboratorCommandHandler
{
    /**
     * @var UniqueChecker
     */
    private $uniqueChecker;

    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * @var EventRecorderInterface
     */
    private $eventRecorder;

    /**
     * AddCollaboratorCommandHandler constructor.
     *
     * @param UniqueChecker                   $uniqueChecker
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     * @param EventRecorderInterface          $eventRecorder
     */
    public function __construct(
        UniqueChecker $uniqueChecker,
        CollaboratorRepositoryInterface $collaboratorRepository,
        EventRecorderInterface $eventRecorder
    ) {
        $this->uniqueChecker = $uniqueChecker;
        $this->collaboratorRepository = $collaboratorRepository;
        $this->eventRecorder = $eventRecorder;
    }

    /**
     * @var AddCollaboratorCommand $command
     *
     * @return Collaborator
     */
    public function handle(AddCollaboratorCommand $command)
    {
        $collaborator = new Collaborator($command->user, $command->board, Collaborator::LEVEL_READ);

        $this->uniqueChecker->check($collaborator);

        $this->collaboratorRepository->add($collaborator);

        $this->eventRecorder->record(new CollaboratorAddedEvent($collaborator, $command->addedBy));

        return $collaborator;
    }
}

