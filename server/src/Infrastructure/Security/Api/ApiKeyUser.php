<?php

namespace App\Infrastructure\Security\Api;

use Symfony\Component\Security\Core\User\UserInterface;

class ApiKeyUser implements UserInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * ApiKeyUser constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_API'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }
}
