<?php

namespace App\Domain\Rules\Board;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\User;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class LevelChecker
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * CollaboratorVoter constructor.
     *
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     */
    public function __construct(CollaboratorRepositoryInterface $collaboratorRepository)
    {
        $this->collaboratorRepository = $collaboratorRepository;
    }

    /**
     * Check a user has a particular access level to a board
     *
     * @param Board  $board
     * @param User   $user
     * @param string $level
     *
     * @return bool
     */
    public function check(Board $board, User $user, string $level) : bool
    {
        try {
            $this->collaboratorRepository->findOneByBoardUserAndLevel($board, $user, $level);

            return true;
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
}
