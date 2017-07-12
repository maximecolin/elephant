<?php

namespace App\Ui\Action\Board\Settings;

use App\Application\Command\Board\RemoveCollaboratorCommand;
use App\Domain\Exception\Collaborator\NoOwnerLeftException;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Infrastructure\Helper\SecurityTrait;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RemoveCollaboratorAction
{
    use SecurityTrait;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RemoveCollaborator constructor.
     *
     * @param BoardRepositoryInterface      $boardRepository
     * @param CommandBus                    $commandBus
     * @param FlashBagInterface             $flashBag
     * @param RouterInterface               $router
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        CommandBus $commandBus,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->boardRepository = $boardRepository;
        $this->commandBus = $commandBus;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param int $boardId
     * @param int $userId
     *
     * @return RedirectResponse
     */
    public function __invoke(int $boardId, int $userId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_OWNER', $board);

        try {
            $this->commandBus->handle(new RemoveCollaboratorCommand($boardId, $userId));
            $this->flashBag->add('inverse', 'Le collaborateur a été supprimé.');
        } catch (NoOwnerLeftException $exception) {
            $this->flashBag->add('danger', $exception->getMessage());
        }

        if ($this->isGranted('COLLABORATOR_OWNER', $board)) {
            $url = $this->router->generate('board_settings_collaborator', ['boardId' => $boardId]);
        } else {
            $url = $this->router->generate('home');
        }

        return new RedirectResponse($url);
    }
}
