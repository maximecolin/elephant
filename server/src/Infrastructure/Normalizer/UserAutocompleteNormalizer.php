<?php

namespace App\Infrastructure\Normalizer;

use App\Domain\Model\User;

class UserAutocompleteNormalizer
{
    /**
     * @param User $user
     *
     * @return array
     */
    public function normalize(User $user)
    {
        return [
            'id' => $user->getId(),
            'name' => (string) $user,
            'email' => $user->getEmail(),
        ];
    }

    /**
     * @param array $users
     *
     * @return array
     */
    public function normalizeAll(array $users)
    {
        return array_map([$this, 'normalize'], $users);
    }
}
