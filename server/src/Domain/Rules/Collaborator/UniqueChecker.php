<?php

namespace App\Domain\Rules\Collaborator;

use App\Domain\Exception\DuplicateException;
use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class UniqueChecker
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * UniqueTitleChecker constructor.
     *
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * @param Collaborator $collaborator
     *
     * @throws DuplicateException
     */
    public function check(Collaborator $collaborator)
    {
        if (!$this->isUnique($collaborator->getBoard(), $collaborator->getUser())) {
            throw new DuplicateException('Collaborator already exists.');
        }
    }

    /**
     * @param Board $board
     * @param User  $user
     *
     * @return bool
     */
    public function isUnique(Board $board, User $user)
    {
        try {
            $collaborator = $this->collaboratorRepository->findOneByBoardAndUser($board, $user);

            return $collaborator->getBoard() !== $board || $collaborator->getUser() !== $user;
        } catch (ModelNotFoundException $exception) {
            return true;
        }
    }
}
