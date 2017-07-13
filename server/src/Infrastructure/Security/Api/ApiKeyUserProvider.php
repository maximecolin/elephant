<?php

namespace App\Infrastructure\Security\Api;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    private $keys;

    /**
     * ApiKeyUserProvider constructor.
     *
     * @param array $keys
     */
    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getUsernameForApiKey(string $key) :? string
    {
        return $this->keys[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        return new ApiKeyUser($username);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return ApiKeyUser::class === $class;
    }
}
