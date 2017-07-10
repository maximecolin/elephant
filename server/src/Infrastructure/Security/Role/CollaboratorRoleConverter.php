<?php

namespace App\Infrastructure\Security\Role;

final class CollaboratorRoleConverter
{
    /**
     * @param string $level
     *
     * @return string
     */
    public static function levelToRole(string $level) : string
    {
        return 'COLLABORATOR_' . strtoupper($level);
    }

    /**
     * @param string $level
     *
     * @return string
     */
    public static function roleToLevel(string $level) : string
    {
        $matches = [];
        
        if (1 === preg_match('/COLLABORATOR_([A-Z]+)/', $level, $matches)) {
            return strtolower($matches[1]);
        }
        
        throw new \InvalidArgumentException('Invalid role.');
    }
}
