<?php

namespace App\Application\Query;

use App\Domain\Dto\BoardListItem;
use App\Domain\Model\Board;
use App\Domain\Repository\BoardRepositoryInterface;

class BoardListQueryHandler
{
    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * BoardListQueryHandler constructor.
     *
     * @param BoardRepositoryInterface $boardRepository
     */
    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    /**
     * @var BoardListQuery $command
     *
     * @return BoardListItem[]
     */
    public function handle(BoardListQuery $command)
    {
        $boards = $this->boardRepository->findByUser($command->user);

        return array_map(function (Board $board) {
            return new BoardListItem($board->getId(), $board->getTitle());
        }, $boards);
    }
}
