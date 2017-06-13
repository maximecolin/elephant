<?php

namespace App\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDoctrineRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * AbstractDoctrineRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
