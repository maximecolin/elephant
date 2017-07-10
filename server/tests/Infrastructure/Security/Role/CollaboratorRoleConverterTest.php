<?php

namespace Tests\Infrastructure\Security\Role;

use App\Infrastructure\Security\Role\CollaboratorRoleConverter;
use PHPUnit\Framework\TestCase;

class CollaboratorRoleConverterTest extends TestCase
{
    public static function provideLevels()
    {
        return [
            ['owner', 'COLLABORATOR_OWNER'],
            ['write', 'COLLABORATOR_WRITE'],
            ['read', 'COLLABORATOR_READ'],
            ['foobar', 'COLLABORATOR_FOOBAR'],
        ];
    }

    /**
     * @dataProvider provideLevels
     *
     * @param string $level
     * @param string $expected
     */
    public function testLevelToRole(string $level, string $expected)
    {
        $this->assertEquals($expected, CollaboratorRoleConverter::levelToRole($level));
    }

    public static function provideRoles()
    {
        return [
            ['COLLABORATOR_OWNER', 'owner'],
            ['COLLABORATOR_WRITE', 'write'],
            ['COLLABORATOR_READ', 'read'],
            ['COLLABORATOR_FOOBAR', 'foobar'],
        ];
    }

    /**
     * @dataProvider provideRoles
     *
     * @param string $role
     * @param string $expected
     */
    public function testRoleToLevel(string $role, string $expected)
    {
        $this->assertEquals($expected, CollaboratorRoleConverter::roleToLevel($role));
    }

    public function testReversibility()
    {
        $this->assertEquals('foobar', CollaboratorRoleConverter::roleToLevel(CollaboratorRoleConverter::levelToRole('foobar')));
        $this->assertEquals('COLLABORATOR_FOOBAR', CollaboratorRoleConverter::levelToRole(CollaboratorRoleConverter::roleToLevel('COLLABORATOR_FOOBAR')));
    }

    public static function provideInvalidRoles()
    {
        return [
            ['foobar'],
            ['ROLE_WRITE'],
            ['WRITE'],
        ];
    }

    /**
     * @dataProvider provideInvalidRoles
     *
     * @param string $role
     */
    public function testInvalidRole(string $role)
    {
        $this->expectException(\InvalidArgumentException::class);
        CollaboratorRoleConverter::roleToLevel($role);
    }
}
