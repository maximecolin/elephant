<?php

namespace App\Infrastructure\Security\Voter;

use App\Domain\Model\Board;
use App\Domain\Rules\Board\LevelChecker;
use App\Infrastructure\Security\Role\CollaboratorRoleConverter;
use App\Infrastructure\Security\User\SymfonyUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CollaboratorVoter extends Voter
{
    /**
     * @var LevelChecker
     */
    private $checker;

    /**
     * CollaboratorVoter constructor.
     *
     * @param LevelChecker $checker
     */
    public function __construct(LevelChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user  = $token->getUser();
        $level = CollaboratorRoleConverter::roleToLevel($attribute);

        if ($user instanceof SymfonyUser && $subject instanceof Board) {
            // Use the LevelChecker domain serivice to check is the use has the requested access level
            return $this->checker->check($subject, $user->getModel(), $level);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        // Support COLLABORATOR_* roles and Board object
        return 1 === strpos($attribute, 'COLLABORATOR_') && is_object($subject) && $subject instanceof Board;
    }
}
