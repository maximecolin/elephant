<?php

namespace App\Domain\Rules\Board;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use App\Domain\Repository\CollaboratorRepositoryInterface;

class LevelChecker
{
    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * @var array
     */
    private $hierarchy = [
        Collaborator::LEVEL_OWNER => [Collaborator::LEVEL_READ, Collaborator::LEVEL_WRITE],
        Collaborator::LEVEL_WRITE => [Collaborator::LEVEL_READ],
        Collaborator::LEVEL_READ  => [],
    ];

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
            $collaborator = $this->collaboratorRepository->findOneByBoardUserAndLevel($board, $user);

            return $this->checkLevel($collaborator->getLevel(), $level);
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }

    /**
     * @param string $collaboratorLevel
     * @param string $checkedLevel
     *
     * @return bool
     */
    public function checkLevel(string $collaboratorLevel, string $checkedLevel)
    {
        return in_array($checkedLevel, $this->getReachableLevels($collaboratorLevel));
    }

    /**
     * @param string $level
     *
     * @return array
     */
    private function getReachableLevels(string $level) : array
    {
        return array_merge(
            $this->hierarchy[$level] ?? [],
            [$level]
        );
    }
}
