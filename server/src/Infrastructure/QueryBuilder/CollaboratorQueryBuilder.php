<?php

namespace App\Infrastructure\QueryBuilder;

use App\Domain\Model\Collaborator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CollaboratorQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->select('collaborator')->from(Collaborator::class, 'collaborator');
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function filterByEmail(string $email)
    {
        $this
            ->andWhere('collaborator.email = :email')
            ->setParameter('email', $email);

        return $this;
    }
}
