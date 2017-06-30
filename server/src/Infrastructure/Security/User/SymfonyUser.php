<?php

namespace App\Infrastructure\Security\User;

use App\Domain\Model\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyUser implements UserInterface
{
    /**
     * @var User
     */
    private $model;

    /**
     * SymfonyUser constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get model
     *
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->model->isAdmin() ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->model->getPassword();
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // Bcrypt encoder used: the encoder generated its own built-in salt
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->model->getEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->model;
    }
}
