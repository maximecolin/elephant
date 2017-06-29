<?php

namespace App\Application\Command\Board;

use App\Domain\Model\User;

class CreateBoardCommand
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $title;

    /**
     * CreateBoardCommand constructor.
     *
     * @param User   $user
     * @param string $title
     */
    public function __construct(User $user, string $title = null)
    {
        $this->user = $user;
        $this->title = $title;
    }
}
