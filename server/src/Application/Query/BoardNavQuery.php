<?php

namespace App\Application\Query;

use App\Domain\Model\User;

class BoardNavQuery
{
    /**
     * @var User
     */
    public $user;

    /**
     * BoardNavQuery constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
