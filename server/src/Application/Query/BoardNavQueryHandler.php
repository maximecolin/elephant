<?php

namespace App\Application\Query;

use App\Domain\Dto\BoardNavItem;
use App\Domain\Repository\BoardRepositoryInterface;

class BoardNavQueryHandler
{
    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * BoardNavQueryHandler constructor.
     *
     * @param BoardRepositoryInterface $boardRepository
     */
    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * @var BoardNavQuery $command
     *
     * @return BoardNavItem[]
     */
    public function handle(BoardNavQuery $command)
    {
        return $this->boardRepository->getNavItems($command->user);
    }
}

