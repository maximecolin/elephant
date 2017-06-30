<?php

namespace App\Ui\Action\Board;

use App\Application\Command\Board\UpdateSettingsCommand;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Domain\Repository\CollaboratorRepositoryInterface;
use App\Ui\Form\Type\Board\UpdateSettingsType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

class SettingsAction
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
     * SettingsAction constructor.
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

    public function __invoke(Request $request, int $boardId)
    {
        $board = $this->boardRepository->findOneById($boardId);
        $collaborators = $this->collaboratorRepository->findByBoardId($boardId);

        $command = new UpdateSettingsCommand($board, $collaborators);
        $form = $this->formFactory->create(UpdateSettingsType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'La configuration a été mis à jour');

            return new RedirectResponse($this->router->generate());
        }

        return $this->engine->renderResponse('board/settings.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
