<?php

namespace App\Infrastructure\Security\Voter;

use App\Domain\Dto\BoardListItem;
use App\Domain\Rules\Board\LevelChecker;
use App\Infrastructure\Security\Role\CollaboratorRoleConverter;
use App\Infrastructure\Security\User\SymfonyUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BoardListItemVoter extends Voter
{
    /**
     * @var LevelChecker
     */
    private $levelChecker;

    /**
     * CollaboratorVoter constructor.
     *
     * @param LevelChecker $levelChecker
     */
    public function __construct(LevelChecker $levelChecker)
    {
        $this->levelChecker = $levelChecker;
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user  = $token->getUser();
        $level = CollaboratorRoleConverter::roleToLevel($attribute);

        if ($user instanceof SymfonyUser && $subject instanceof BoardListItem) {
            // Use the LevelChecker domain service to check is the use has the requested access level
            return $this->levelChecker->checkLevel($subject->level, $level);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject)
    {
        // Support COLLABORATOR_* roles and BoardListItem objects
        return 0 === strpos($attribute, 'COLLABORATOR_') && is_object($subject) && $subject instanceof BoardListItem;
    }
}
