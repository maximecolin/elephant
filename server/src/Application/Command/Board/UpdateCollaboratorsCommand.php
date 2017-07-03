<?php

namespace App\Application\Command\Board;

use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;

class UpdateCollaboratorsCommand
{
    /**
     * @var Board
     */
    public $board;

    /**
     * @var Collaborator[]
     */
    public $collaborators;

    /**
     * UpdateSettingsCommand constructor.
     *
     * @param Board          $board
     * @param Collaborator[] $collaborators
     */
    public function __construct(Board $board, array $collaborators)
    {
        $this->board = $board;
        $this->collaborators = array_map(function (Collaborator $collaborator) {
            return [
                'user' => (string) $collaborator->getUser(),
                'user_id' => $collaborator->getUser()->getId(),
                'board_id' => $collaborator->getBoard()->getId(),
                'level' => $collaborator->getLevel(),
            ];
        }, $collaborators);
    }
}
