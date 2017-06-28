<?php

namespace App\Infrastructure\Security\User;

use App\Domain\Model\Collaborator;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyUser implements UserInterface
{
    /**
     * @var Collaborator
     */
    private $collaborator;

    /**
     * SymfonyUser constructor.
     *
     * @param Collaborator $collaborator
     */
    public function __construct(Collaborator $collaborator)
    {
        $this->collaborator = $collaborator;
    }

    /**
     * Get collaborator
     *
     * @return Collaborator
     */
    public function getCollaborator()
    {
        return $this->collaborator;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->collaborator->isAdmin() ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->collaborator->getPassword();
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
        return $this->collaborator->getEmail();
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
        return sprintf('%s %s', $this->collaborator->getFirstname(), $this->collaborator->getLastname());
    }
}
