<?php

namespace App\Infrastructure\Security\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $providerKey)
    {
        $header = $request->headers->get('Authorization');
        $key = $this->extractKey($header);

        if (null === $key) {
            throw new BadCredentialsException('No key provided.');
        }

        return new PreAuthenticatedToken('anon.', $key, $providerKey);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException('Wrong user provider.');
        }

        $key = $token->getCredentials();
        $username = $userProvider->getUsernameForApiKey($key);

        if (null === $username) {
            throw new CustomUserMessageAuthenticationException('API key is not valid.');
        }

        $user = $userProvider->loadUserByUsername($username);

        return new PreAuthenticatedToken($user, $key, $providerKey, $user->getRoles());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'errors' => [
                ['message' => strtr($exception->getMessageKey(), $exception->getMessageData())],
            ]
        ], 401);
    }

    /**
     * @param string $header
     *
     * @return string|null
     */
    private function extractKey(string $header)
    {
        $matches = [];

        if (1 === preg_match('/^Bearer (.+)$/', $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
