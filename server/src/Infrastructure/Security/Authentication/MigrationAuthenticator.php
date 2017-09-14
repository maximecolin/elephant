<?php

namespace App\Infrastructure\Security\Authentication;

use App\Infrastructure\Security\User\SymfonyUser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;

class MigrationAuthenticator implements SimpleFormAuthenticatorInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityRepository
     */
    private $em;

    /**
     * MigrationAuthenticator constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManager                $em
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManager $em)
    {
        $this->encoder = $encoder;
        $this->em      = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        try {
            /** @var SymfonyUser $user */
            $user = $userProvider->loadUserByUsername($token->getUsername());
            $model = $user->getModel();
        } catch (UsernameNotFoundException $exception) {
            throw new BadCredentialsException('Invalid username or password');
        }

        $password = $token->getCredentials();

        // The user hasn't password, it's not migrated
        if (null === $user->getPassword()) {
            // Check legacy password with legacy encoding method
            if (md5($password . $model->getLegacySalt()) === $model->getLegacyPassword()) {

                // Encode the password and migrate the user
                $encodedPassword = $this->encoder->encodePassword($user, $password);
                $model->updatePassword($encodedPassword);
                $this->em->flush($model);

                return new UsernamePasswordToken($user, $user->getPassword(), $providerKey, $user->getRoles());
            }
        } else {
            // Check password with the current encoder
            if ($this->encoder->isPasswordValid($user, $password)) {
                return new UsernamePasswordToken($user, $user->getPassword(), $providerKey, $user->getRoles());
            }
        }

        throw new BadCredentialsException('Invalid username or password');
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof UsernamePasswordToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new UsernamePasswordToken($username, $password, $providerKey);
    }
}
