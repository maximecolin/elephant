<?php

namespace App\Ui\Action\Board\Settings;

use App\Application\Command\Board\UpdateBoardCommand;
use App\Domain\Repository\BoardRepositoryInterface;
use App\Infrastructure\Helper\SecurityTrait;
use App\Ui\Form\Type\Board\UpdateType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class OptionsAction
{
    use SecurityTrait;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var BoardRepositoryInterface
     */
    private $boardRepository;

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
     * OptionsAction constructor.
     *
     * @param CommandBus                    $commandBus
     * @param BoardRepositoryInterface      $boardRepository
     * @param FormFactoryInterface          $formFactory
     * @param FlashBagInterface             $flashBag
     * @param RouterInterface               $router
     * @param EngineInterface               $engine
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        CommandBus $commandBus,
        BoardRepositoryInterface $boardRepository,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        EngineInterface $engine,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->commandBus = $commandBus;
        $this->boardRepository = $boardRepository;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->engine = $engine;
        $this->authorizationChecker = $authorizationChecker;
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
        $this->denyAccessUnlessGranted('COLLABORATOR_OWNER', $board);

        $command = new UpdateBoardCommand($board);
        $form = $this->formFactory->create(UpdateType::class, $command);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($command);
            $this->flashBag->add('inverse', 'La configuration a été mis à jour');

            return new RedirectResponse($this->router->generate('board_settings_options', [
                'boardId' => $board->getId(),
            ]));
        }

        return $this->engine->renderResponse('board/settings/options.html.twig', [
            'board' => $board,
            'form' => $form->createView(),
        ]);
    }
}
