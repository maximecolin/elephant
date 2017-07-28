<?php

namespace App\Infrastructure\Controller;

use App\Domain\Model\User;
use App\Infrastructure\Security\User\SymfonyUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * UserValueResolver constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if (User::class !== $argument->getType()) {
            return false;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token instanceof TokenInterface) {
            return false;
        }

        $user = $token->getUser();

        return $user instanceof SymfonyUser;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $this->tokenStorage->getToken()->getUser()->getModel();
    }
}
