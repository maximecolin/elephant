<?php

namespace App\Application\Query;

use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Normalizer\UserAutocompleteNormalizer;

class UserAutocompleteQueryHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserAutocompleteNormalizer
     */
    private $normalizer;

    /**
     * UserAutocompleteQueryHandler constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function  __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->normalizer = new UserAutocompleteNormalizer();
    }

    /**
     * @var UserAutocompleteQuery $command
     *
     * @return array
     */
    public function handle(UserAutocompleteQuery $command)
    {
        $users = $this->userRepository->findByTerm($command->term, $command->boardId);

        return $this->normalizer->normalizeAll($users);
    }
}

