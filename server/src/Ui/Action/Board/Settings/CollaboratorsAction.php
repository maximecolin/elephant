<?php

namespace App\Ui\Action\Board\Settings;

use App\Application\Command\Board\AddCollaboratorCommand;
use App\Application\Command\Board\UpdateCollaboratorsCommand;
use App\Domain\Model\User;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Infrastructure\Helper\RoutingTrait;
use App\Infrastructure\Helper\SecurityTrait;
use App\Ui\Form\Type\Board\AddCollaboratorType;
use App\Ui\Form\Type\Board\CollaboratorsType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CollaboratorsAction
{
    use SecurityTrait;
    use RoutingTrait;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

    /**
     * @var CollaboratorRepositoryInterface
     */
    private $collaboratorRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * CollaboratorsAction constructor.
     *
     * @param CommandBus                      $commandBus
     * @param BoardRepositoryInterface        $boardRepository
     * @param CollaboratorRepositoryInterface $collaboratorRepository
     * @param FormFactoryInterface            $formFactory
     * @param FlashBagInterface               $flashBag
     * @param RouterInterface                 $router
     * @param EngineInterface                 $engine
     * @param AuthorizationCheckerInterface   $authorizationChecker
     */
    public function __construct(
        CommandBus $commandBus,
        BoardRepositoryInterface $boardRepository,
        CollaboratorRepositoryInterface $collaboratorRepository,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        EngineInterface $engine,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->commandBus = $commandBus;
        $this->boardRepository = $boardRepository;
        $this->collaboratorRepository = $collaboratorRepository;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->engine = $engine;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Request $request
     * @param User    $user
     * @param int     $boardId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, User $user, int $boardId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $this->denyAccessUnlessGranted('COLLABORATOR_OWNER', $board);
        $collaborators = $this->collaboratorRepository->findByBoardId($boardId);

        // Handle collaborators update
        $updateCommand = new UpdateCollaboratorsCommand($board, $collaborators);
        $updateForm = $this->formFactory->create(CollaboratorsType::class, $updateCommand);

        if ($updateForm->handleRequest($request)->isSubmitted() && $updateForm->isValid()) {
            $this->commandBus->handle($updateCommand);
            $this->flashBag->add('inverse', 'La configuration a été mis à jour');

            return $this->redirectToRoute('board_settings_collaborator', [
                'boardId' => $board->getId(),
            ]);
        }

        // Handle collaborator add
        $addCommand = new AddCollaboratorCommand($board, $user);
        $addForm = $this->formFactory->create(AddCollaboratorType::class, $addCommand, ['board' => $board]);

        if ($addForm->handleRequest($request)->isSubmitted() && $addForm->isValid()) {
            $this->commandBus->handle($addCommand);
            $this->flashBag->add('inverse', 'Le collaborator a été ajouté');

            return $this->redirectToRoute('board_settings_collaborator', [
                'boardId' => $board->getId(),
            ]);
        }

        return $this->engine->renderResponse('board/settings/collaborators.html.twig', [
            'board' => $board,
            'update_form' => $updateForm->createView(),
            'add_form' => $addForm->createView(),
        ]);
    }
}
