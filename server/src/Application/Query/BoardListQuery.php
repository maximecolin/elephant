<?php

namespace App\Application\Query;

use App\Domain\Model\User;

class BoardListQuery
{
    /**
     * @var User
     */
    public $user;

    /**
     * BoardListQuery constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
