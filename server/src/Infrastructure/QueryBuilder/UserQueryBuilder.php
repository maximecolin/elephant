<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\Collaborator;
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
     * @param int $id
     *
     * @return $this
     */
    public function filterById(int $id)
    {
        $this
            ->andWhere('user.id = :id')
            ->setParameter('id', $id);

        return $this;
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

    /**
     * @param string $term
     *
     * @return $this
     */
    public function filterByTerm(string $term)
    {
        $this
            ->andWhere('user.firstname LIKE :term OR user.lastname LIKE :term OR user.email LIKE :term')
            ->setParameter('term', '%' . $term . '%');

        return $this;
    }

    /**
     * @param int $boardId
     *
     * @return $this
     */
    public function excludeBoardCollaborator(int $boardId)
    {
        $this
            ->andWhere(sprintf('NOT EXISTS (SELECT c.level FROM %s c WHERE c.user = user AND c.board = :board_id)', Collaborator::class))
            ->setParameter('board_id', $boardId);

        return $this;
    }
}
