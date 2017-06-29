<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\User;

interface UserRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return User
     * @throws ModelNotFoundException
     */
    public function findOneByEmail(string $email) : User;
}
