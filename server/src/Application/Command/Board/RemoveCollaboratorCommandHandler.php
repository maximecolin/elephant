<?php

namespace App\Application\Command\Board;

use App\Domain\Exception\Collaborator\NoOwnerLeftException;
use App\Domain\Model\Collaborator;
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
     *
     * @throws NoOwnerLeftException
     */
    public function handle(RemoveCollaboratorCommand $command)
    {
        $collaborator = $this->collaboratorRepository->findOneByBoardIdAndUserId($command->boardId, $command->userId);

        if ($collaborator->isOwner() && $this->countByLevel($collaborator) < 2) {
            throw new NoOwnerLeftException('You must keep at least one owner collaborator.');
        }

        $this->collaboratorRepository->remove($collaborator);
    }

    /**
     * @param $collaborator
     *
     * @return int
     */
    private function countByLevel(Collaborator $collaborator): int
    {
        return $this->collaboratorRepository->countByLevel($collaborator->getBoard(), $collaborator->getLevel());
    }
}

