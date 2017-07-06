<?php

namespace App\Ui\Action\Board\Settings;

use App\Application\Command\Board\AddCollaboratorCommand;
use App\Application\Command\Board\UpdateCollaboratorsCommand;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollaboratorRepositoryInterface;
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

class CollaboratorsAction
{
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
     * @var RouterInterface
     */
    private $router;

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
     */
    public function __construct(
        CommandBus $commandBus,
        BoardRepositoryInterface $boardRepository,
        CollaboratorRepositoryInterface $collaboratorRepository,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        EngineInterface $engine
    ) {
        $this->commandBus = $commandBus;
        $this->boardRepository = $boardRepository;
        $this->collaboratorRepository = $collaboratorRepository;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->engine = $engine;
    }

    /**
     * @param Request $request
     * @param int     $boardId
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, int $boardId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $collaborators = $this->collaboratorRepository->findByBoardId($boardId);

        // Handle collaborators update
        $updateCommand = new UpdateCollaboratorsCommand($board, $collaborators);
        $updateForm = $this->formFactory->create(CollaboratorsType::class, $updateCommand);

        if ($updateForm->handleRequest($request)->isSubmitted() && $updateForm->isValid()) {
            $this->commandBus->handle($updateCommand);
            $this->flashBag->add('inverse', 'La configuration a été mis à jour');

            return new RedirectResponse($this->router->generate('board_settings_collaborator', [
                'boardId' => $board->getId(),
            ]));
        }

        // Handle collaborator add
        $addCommand = new AddCollaboratorCommand($board);
        $addForm = $this->formFactory->create(AddCollaboratorType::class, $addCommand);

        if ($addForm->handleRequest($request)->isSubmitted() && $addForm->isValid()) {
            $this->commandBus->handle($addCommand);
            $this->flashBag->add('inverse', 'Le collaborator a été ajouté');

            return new RedirectResponse($this->router->generate('board_settings_collaborator', [
                'boardId' => $board->getId(),
            ]));
        }

        return $this->engine->renderResponse('board/settings/collaborators.html.twig', [
            'board' => $board,
            'update_form' => $updateForm->createView(),
            'add_form' => $addForm->createView(),
        ]);
    }
}
