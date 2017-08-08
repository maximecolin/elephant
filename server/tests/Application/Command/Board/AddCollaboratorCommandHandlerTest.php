<?php

namespace Tests\Application\Command\Board;

use App\Application\Command\Board\AddCollaboratorCommand;
use App\Application\Command\Board\AddCollaboratorCommandHandler;
use App\Application\Event\EventRecorderInterface;
use App\Domain\Event\CollaboratorAddedEvent;
use App\Domain\Exception\DuplicateException;
use App\Domain\Model\Board;
use App\Domain\Model\Collaborator;
use App\Domain\Model\User;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Domain\Rules\Collaborator\UniqueChecker;
use PHPUnit\Framework\TestCase;

class AddCollaboratorCommandHandlerTest extends TestCase
{
    public function testHandle()
    {
        $board = new Board('title');
        $owner = new User('owner@email.com', 'password', 'owner', 'lastname');
        $user = new User('user@email.com', 'password', 'user', 'lastname');

        $uniqueChecker = $this->prophesize(UniqueChecker::class);
        $collaboratorRepository = $this->prophesize(CollaboratorRepositoryInterface::class);
        $eventRecorder = $this->prophesize(EventRecorderInterface::class);

        $expected = new Collaborator($user, $board, Collaborator::LEVEL_READ);
        $event = new CollaboratorAddedEvent($expected, $owner);

        $uniqueChecker->check($expected)->shouldBeCalled();
        $collaboratorRepository->add($expected)->shouldBeCalled();
        $eventRecorder->record($event)->shouldBeCalled();

        $handler = new AddCollaboratorCommandHandler(
            $uniqueChecker->reveal(),
            $collaboratorRepository->reveal(),
            $eventRecorder->reveal()
        );

        $command = new AddCollaboratorCommand($board, $owner);
        $command->user = $user;

        $this->assertEquals($expected, $handler->handle($command));
    }

    public function testHandleNotUnique()
    {
        $this->expectException(DuplicateException::class);

        $board = new Board('title');
        $owner = new User('owner@email.com', 'password', 'owner', 'lastname');
        $user = new User('user@email.com', 'password', 'user', 'lastname');

        $uniqueChecker = $this->prophesize(UniqueChecker::class);
        $collaboratorRepository = $this->prophesize(CollaboratorRepositoryInterface::class);
        $eventRecorder = $this->prophesize(EventRecorderInterface::class);

        $expected = new Collaborator($user, $board, Collaborator::LEVEL_READ);

        $uniqueChecker->check($expected)->shouldBeCalled()->willThrow(new DuplicateException());
        $collaboratorRepository->add()->shouldNotBeCalled();
        $eventRecorder->record()->shouldNotBeCalled();

        $handler = new AddCollaboratorCommandHandler(
            $uniqueChecker->reveal(),
            $collaboratorRepository->reveal(),
            $eventRecorder->reveal()
        );

        $command = new AddCollaboratorCommand($board, $owner);
        $command->user = $user;

        $handler->handle($command);
    }
}
