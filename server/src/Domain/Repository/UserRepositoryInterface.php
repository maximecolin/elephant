<?php

namespace App\Domain\Repository;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return User
     * @throws ModelNotFoundException
     */
    public function findOneById(int $id) : User;

    /**
     * @param string $email
     *
     * @return User
     * @throws ModelNotFoundException
     */
    public function findOneByEmail(string $email) : User;

    /**
     * @param string $term
     *
     * @return User[]
     */
    public function findByTerm(string $term) : array;
}
