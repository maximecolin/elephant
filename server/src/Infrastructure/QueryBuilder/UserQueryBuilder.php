<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class UserQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('user')->from(User::class, 'user');
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function filterByEmail(string $email)
    {
        $this
            ->andWhere('user.email = :email')
            ->setParameter('email', $email);

        return $this;
    }
}
