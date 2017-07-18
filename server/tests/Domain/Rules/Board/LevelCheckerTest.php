<?php

namespace Tests\Domain\Rules\Board;

use App\Domain\Exception\ModelNotFoundException;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Domain\Rules\Board\LevelChecker;
use PHPUnit\Framework\TestCase;

class LevelCheckerTest extends TestCase
{
    public static function provideLevels()
    {
        return [
            // READ
            [true, Collaborator::LEVEL_READ, Collaborator::LEVEL_READ],
            [false, Collaborator::LEVEL_WRITE, Collaborator::LEVEL_READ],
            [false, Collaborator::LEVEL_OWNER, Collaborator::LEVEL_READ],
            // WRITE
            [true, Collaborator::LEVEL_READ, Collaborator::LEVEL_WRITE],
            [true, Collaborator::LEVEL_WRITE, Collaborator::LEVEL_WRITE],
            [false, Collaborator::LEVEL_OWNER, Collaborator::LEVEL_WRITE],
            // OWNER
            [true, Collaborator::LEVEL_READ, Collaborator::LEVEL_OWNER],
            [true, Collaborator::LEVEL_WRITE, Collaborator::LEVEL_OWNER],
            [true, Collaborator::LEVEL_OWNER, Collaborator::LEVEL_OWNER],
            // ModelNotFoundException
            [false, Collaborator::LEVEL_READ, null],
            [false, Collaborator::LEVEL_WRITE, null],
            [false, Collaborator::LEVEL_OWNER, null],
        ];
    }

    /**
     * @dataProvider provideLevels
     *
     * @param string $requestedLevel
     * @param string $actualLevel
     * @param bool   $expected
     */
    public function testCheck(bool $expected, string $requestedLevel, string $actualLevel = null)
    {
        $user = new User('email@email.email', 'password', 'firstname', 'lastname');
        $board = new Board('title');

        $collaboratorRepository = $this->prophesize(CollaboratorRepositoryInterface::class);
        $shouldBeCalled = $collaboratorRepository->findOneByBoardAndUser($board, $user)->shouldBeCalled();

        if ($actualLevel === null) {
            $shouldBeCalled->willThrow(new ModelNotFoundException());
        } else {
            $shouldBeCalled->willReturn(new Collaborator($user, $board, $actualLevel));
        }

        $checker = new LevelChecker($collaboratorRepository->reveal());

        $this->assertEquals($expected, $checker->check($board, $user, $requestedLevel));
    }
}
